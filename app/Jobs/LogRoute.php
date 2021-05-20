<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogRoute implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $route;
    protected $type;
    protected $status;
    protected $input;
    protected $output;

    protected $logService;
    protected $runService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($route, $type, $status, $input, $output, $logService, $runService)
    {
        $this->route = $route;
        $this->type = $type;
        $this->status = $status;
        $this->input = $input;
        $this->output = $output;
        $this->logService = $logService;
        $this->runService = $runService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->logService->setOrigin('route', $this->route->id);
        if($this->status == 'success') {
            $level = "info";
        } else {
            $level = "error";
        }

        $this->logService->push('error','just ran with status ' . $this->status . '.', json_encode($this->route));

        $this->runService->store([
            'process_id' => $this->route->id,
            'type' => $this->type,
            'status' => $this->status,
            'input' => $this->input,
            'output' => $this->output
        ]);
    }
}
