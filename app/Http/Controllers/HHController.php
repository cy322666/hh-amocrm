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
        Log::info(__METHOD__, $request->toArray());
//        $respond = Respond::query()->create($request->toArray());
//
//        RespondSend::dispatch($respond);
    }

    public function redirect(Request $request)
    {
        Log::info(__METHOD__, $request->toArray());
    }
}
