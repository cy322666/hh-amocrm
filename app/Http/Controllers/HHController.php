<?php

namespace App\Http\Controllers;

use App\Models\Respond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class HHController extends Controller
{
    public function hook(Request $request)
    {
        $respond = Respond::query()->create($request->toArray());


    }
}
