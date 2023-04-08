<?php

namespace App\Http\Controllers;

use App\Jobs\RespondSend;
use App\Models\Respond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HHController extends Controller
{
    public function hook(Request $request)
    {
        $respond = Respond::query()->firstOrCreate([
            'webhook_id' => $request->id
        ], [
            'body'       => json_encode($request->toArray()),
            'vacancy_id' => $request->payload['vacancy_id'],
            'resume_id'  => $request->payload['resume_id'],
            'status'     => Respond::STATUS_CREATE,
        ]);

        RespondSend::dispatch($respond);
    }

    public function redirect(Request $request)
    {
        Log::info(__METHOD__, $request->toArray());
    }
}
