<?php

namespace App\Jobs;

use App\Models\Respond;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class RespondSend implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Respond $respond) {}

    public function handle()
    {
        Artisan::call('hh:respond-send', ['respond' => $this->respond->id]);
    }
}
