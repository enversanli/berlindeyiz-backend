<?php

namespace App\Console\Commands\OneTimeUsage;

use App\Models\Service;
use App\Models\User;
use Illuminate\Console\Command;

class FakeServiceGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake-service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        Service::factory()->count(550)->create([
            'user_id' => User::first()->id,
            'business_id' => User::first()->business->id,
        ]);
    }
}
