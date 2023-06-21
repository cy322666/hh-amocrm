<?php

namespace App\Jobs;

use App\Models\Respond;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class RespondSend implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//    public int $backoff = 10;

    public int $tries = 1;

    public function __construct(
        public Respond $respond,
        public int $app
    ) {}

//    public function uniqueId()
//    {
//        return $this->respond->app_id;
//    }

    public function handle()
    {
        try {

//            sleep(1);

            Artisan::call('hh:respond-send', [
                'respond' => $this->respond->id,
                'app'     => $this->app,
            ]);

        } catch (\Throwable $e) {

            Log::error(__METHOD__, [$e->getMessage().' '.$e->getFile().' '.$e->getLine()]);

            $this->fail($e);
        }
    }
}
