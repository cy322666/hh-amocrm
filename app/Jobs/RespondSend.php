<?php

namespace App\Jobs;

use App\Models\Respond;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class RespondSend implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Respond $respond) {}

    public function handle()
    {
        Log::info(__METHOD__.' > start');

        Artisan::command("hh:respond-send $this->respond->id", function (string $respondId) {

            Log::info(__METHOD__.' '.$respondId);
        });

        Log::info(__METHOD__.' > finish');
    }
}
