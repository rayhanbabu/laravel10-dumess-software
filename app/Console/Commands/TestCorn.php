<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Hallinfo;

class TestCorn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:corn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * Execute the console command.
     */
    public function handle()
    {

       $data= rayhan();
      
       \Log::info($data);
    }
}
