<?php

namespace App\Http\Controllers;

use App\Jobs\RespondSend;
use App\Models\Respond;
use Illuminate\Http\Request;

class HHController extends Controller
{
    public function hook(Request $request)
    {
        $respond = Respond::query()->create($request->toArray());

        RespondSend::dispatch($respond);
    }
}
