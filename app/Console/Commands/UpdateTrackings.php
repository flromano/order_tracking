<?php

namespace App\Console\Commands;

use App\Models\Tracking;
use App\Services\TrackingService;
use Illuminate\Console\Command;

class UpdateTrackings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trackings:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza os cõdigos de rastreio';

    /**
     * @var TrackingService
     */
    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TrackingService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->service->update();
        return 0;
    }
}
