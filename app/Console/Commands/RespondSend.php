<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Respond;
use App\Services\amoCRM\Client;
use App\Services\amoCRM\Models\Contacts;
use App\Services\amoCRM\Models\Leads;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Throwable;

class RespondSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hh:respond-send {respond}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {

            $respond = Respond::query()->find($this->argument('respond'));

            $hhApi = (new \App\Services\HH\Client(
                Account::query()
                    ->where('name', 'hh')
                    ->first()
            ));

            $resume = $hhApi->resume($respond->resume_id);



            $respond = $respond->fill([
                'name' => $resume['first_name'].' '.$resume['last_name'].' '.$resume['middle_name'],
                'area' => $resume['area']['name'] ?? null,
                'age'  => $resume['age'],
                'email'  => Respond::getContact($resume['contact'][0]['value'] ?? $resume['contact'][1]['value']),
                'title'  => $resume['title'],
                'phone'  => Respond::getContact($resume['contact'][0]['value']['formatted'] ?? $resume['contact'][1]['value']['formatted']),
                'status' => Respond::STATUS_WAIT,
                'gender' => $resume['gender']['name'],
            ]);

            $amoApi = (new Client(
                Account::query()
                    ->where('name', 'amocrm')
                    ->first()
                ))->init();

            $contact = Contacts::search([
                'Телефоны' => [$respond->phone],
                'Почта'    => $respond->email,
            ], $amoApi) ?? Contacts::create($amoApi, $respond->name);

            $contact->cf('Телефон')->setValue($respond->phone);
            $contact->cf('Email')->setValue($respond->email);
            $contact->save();

            $lead = Leads::create($contact, [], $respond->title);
            $lead->cf('Возраст')->setValue($respond->age);
            $lead->cf('Город')->setValue($respond->area);
            $lead->cf('Пол')->setValue($respond->gender);
            $lead->save();

            $respond->lead_id = $lead->id;
            $respond->contact_id = $contact->id;
            $respond->status = Respond::STATUS_SEND;

        } catch (Throwable $e) {

            Log::error(__METHOD__, [$e->getMessage().' '.$e->getFile().' '.$e->getLine()]);

            $respond->status = Respond::STATUS_FAIL;

        } finally {
            $respond->save();
        }
    }
}
