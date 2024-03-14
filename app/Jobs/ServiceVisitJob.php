<?php

namespace App\Jobs;

use App\Http\Actions\Service\ServiceVisitAction;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ServiceVisitJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Service */
    protected $service;

    protected $ip;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Service $service, $ip)
    {
        $this->service = $service;
        $this->ip = $ip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new ServiceVisitAction())->execute($this->service, $this->ip);
    }
}
