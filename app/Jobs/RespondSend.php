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

class RespondSend implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public Respond $respond) {}

    public function uniqueId()
    {
        return $this->respond->id;
    }

    public function handle()
    {
        try {

            Artisan::call('hh:respond-send', ['respond' => $this->respond->id]);

        } catch (GuzzleException $e) {

            $this->fail($e);
        }
    }
}
