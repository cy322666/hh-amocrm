<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Manager;
use App\Services\HH\Client;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class GetManagers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hh:managers';

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
        $hhApi = (new Client(
            Account::query()
                ->where('name', 'hh')
                ->first()
        ));

        $managers = $hhApi->managers(5892729);

        foreach ($managers as $manager) {

            Manager::query()->create([
                "first_name"  => $manager['first_name'],
                "last_name"   => $manager['last_name'],
                "middle_name" => $manager['middle_name'],
                "position"    => $manager['position'],
                "email"       => $manager['email'],
                "manager_id"  => $manager['id'],
            ]);
        }

        return CommandAlias::SUCCESS;
    }
}
