<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Services\CBRData;
use Illuminate\Console\Command;

class CurrencyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill database currencies with CBR';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle(CBRData $service)
    {
        $isLoad = $service->load();
        if ($isLoad) {
            $allData = $service->getCurrencyAll();
            (new Currency())->saveCurrency($allData);
        }
    }
}
