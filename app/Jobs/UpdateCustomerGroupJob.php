<?php

namespace App\Jobs;

use App\Logs\QALog;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCustomerGroupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $logFile = 'job';

    private $data;

    /**
     * Create a new job instance.
     *
     * @param $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        QALog::info(__METHOD__ . '=== test12 ===', $this->data, $this->logFile);
    }

}
