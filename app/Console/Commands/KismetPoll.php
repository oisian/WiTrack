<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\KisParseController;

class KismetPoll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kismet:poll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pulls data from kismet based on last timestamp reading';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(KisParseController $kis)
    {
        parent::__construct();
        $this->kis = $kis;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->kis->get_kismet_records_from_timestamp($this->kis->hosts);
    }
}
