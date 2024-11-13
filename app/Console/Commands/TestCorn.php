<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Feedback;

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
        $time=date('Y-m-d H:i:s');
        $model= new Feedback;
        $model->hall_id="34345";
        $model->member_id=122;
        $model->submited_time=$time; 
        $model->category="Resign"; 
        $model->subject="Subject";
        $model->text="Text";
        $model->resign_month="Month";
        $model->save();
         \Log::info($model);
    }
}
