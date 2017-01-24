<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\LotRepository;

class UpdateStatusLot extends Command
{
    /**
    * @var LotRepository
    */
    protected $lots;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:verify_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update verify_status for lot';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(LotRepository $lotRepository)
    {
        parent::__construct();
        $this->lots = $lotRepository;
    }
    public function handle()
    {
        $this->lots->updateExpiredStatus('expired');
    }
}