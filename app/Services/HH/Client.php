<?php


namespace App\Services\HH;


use App\Models\Account;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Client
{
    private static string $baseUrl = 'https://api.hh.ru';
    private string $access_token;
    private string $refresh_token;

    private Model $account;
    private \GuzzleHttp\Client $client;

    public function __construct(Model $account)
    {
        $this->access_token  = $account->access_token;
        $this->refresh_token = $account->refresh_token;

        $this->account = $account;
        $this->client  = new \GuzzleHttp\Client();
    }

    /**
     * @throws GuzzleException
     */
    public function managers(int $employer_id) : array
    {
        return $this->get('/employers/'.$employer_id.'/managers', [])['items'];
    }

    /**
     * @throws GuzzleException
     */
    public function vacancies(int $employer_id, int $manager_id) : array
    {
        return $this->get('/employers/'.$employer_id.'/vacancies/active?manager_id='.$manager_id, [])['items'];
    }

    /**
     * @throws GuzzleException
     */
    public function vacancy(int $vacancy_id) : array
    {
        return $this->get('/vacancies/'.$vacancy_id, []);
    }

    /**
     * @throws GuzzleException
     */
    public function unsorted(int $vacancy_id) : array
    {
        return $this->get('/negotiations/response?vacancy_id='.$vacancy_id, []);
    }

    /**
     * @throws GuzzleException
     */
    public function show(int $negotiation_id): array
    {
        return $this->get('/negotiations/'.$negotiation_id, []);
    }

    /**
     * @throws GuzzleException
     */
    public function resume(string $resume_id) : array
    {
        return $this->get('/resumes/'.$resume_id, []);
    }

    /**
     * @throws GuzzleException
     */
    public function messages(string $negotiation_id) : array
    {
        return $this->get('/negotiations/'.$negotiation_id.'/messages', []);
    }

    /**
     * @throws GuzzleException
     */
    private function get(string $url, array $params = []) : array
    {
            $response = $this->client->get(static::$baseUrl.$url, [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->access_token,
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);


//        } catch (\Throwable $exception) {
//
//            Log::error(__METHOD__, [$exception->getMessage()]);
//
//            $this->auth();
//
//            return $this->get($url, $params);
//        }
    }

    /**
     * @throws GuzzleException
     */
    private function post(string $url, array $params = []) : array
    {
        try {

            $response = $this->client->post(static::$baseUrl.$url, [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->access_token,
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);

        } catch (\Throwable $exception) {

            $this->auth();

            return $this->post($url, $params);
        }
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function auth()
    {
        $response = $this->client->post('https://hh.ru/oauth/token?grant_type=refresh_token&refresh_token='.$this->refresh_token, []);

        if($response->getStatusCode() == 200) {

            $array_body = json_decode($response->getBody()->getContents(), true);

            Log::info(__METHOD__, $array_body);

            $this->account->access_token  = $array_body['access_token'];
            $this->account->token_type    = $array_body['token_type'];
            $this->account->expires_in    = $array_body['expires_in'];
            $this->account->refresh_token = $array_body['refresh_token'];
            $this->account->save();

        } else
            throw new Exception('не получилось обновить ключи');
    }

    private function checkResponse(Response $response) : bool
    {
        return (bool)$response->getStatusCode() == 200;
    }
}
