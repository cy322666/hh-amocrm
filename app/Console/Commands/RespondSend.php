<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Respond;
use App\Services\amoCRM\Client;
use App\Services\amoCRM\Models\Contacts;
use App\Services\amoCRM\Models\Leads;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Throwable;

class RespondSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hh:respond-send {respond}';

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
    public function handle(): int
    {
        try {
            $respond = Respond::query()
                ->find($this->argument('respond'));

            $amoApi = (new Client(Account::query()
                ->first()))
                ->init();

            $contact = Contacts::search([], $amoApi) ?? Contacts::create($amoApi, '');

            $lead = Leads::create($contact, [], '');

            $respond->lead_id = $lead->id;
            $respond->contact_id = $contact->id;
            $respond->save();
            //TODO

        } catch (Throwable $e) {

            Log::error(__METHOD__, [$e->getMessage().' '.$e->getFile().' '.$e->getLine()]);

            return CommandAlias::INVALID;
        }

        return CommandAlias::SUCCESS;
    }
}
