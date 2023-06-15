<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Respond;
use App\Services\HH\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Command\Command as CommandAlias;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hh:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $responds = Respond::query()
            ->where('lead_id', null)
            ->where('created_at', '>', '2023-06-15 00:28:33')
            ->get();

        foreach ($responds as $respond) {

            Artisan::call('hh:respond-send '.$respond->id);

            sleep(1);
        }

        return CommandAlias::SUCCESS;
    }
}
