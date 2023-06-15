<?php

namespace App\Http\Controllers;

use App\Jobs\RespondSend;
use App\Models\Respond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HHController extends Controller
{
    private static int $app1 = 1;
    private static int $app2 = 2;

    public function hook1(Request $request)
    {
        $respond = Respond::query()->firstOrCreate([
            'webhook_id' => $request->id
        ], [
            'body'       => json_encode($request->toArray()),
            'vacancy_id' => $request->payload['vacancy_id'],
            'resume_id'  => $request->payload['resume_id'],
            'status'     => Respond::STATUS_CREATE,
            'app_id'     => static::$app1,
        ]);

        RespondSend::dispatch($respond, static::$app1)->delay(5);
    }

    public function hook2(Request $request)
    {
        $respond = Respond::query()->firstOrCreate([
            'webhook_id' => $request->id
        ], [
            'body'       => json_encode($request->toArray()),
            'vacancy_id' => $request->payload['vacancy_id'],
            'resume_id'  => $request->payload['resume_id'],
            'status'     => Respond::STATUS_CREATE,
            'app_id'     => static::$app2,
        ]);

        RespondSend::dispatch($respond, static::$app2)->delay(5);
    }

    public function redirect(Request $request)
    {
        Log::info(__METHOD__, $request->toArray());
    }
}
