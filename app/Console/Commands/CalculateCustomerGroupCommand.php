<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class calculateCustomerGroupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crm:calculate_customer_group';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '计算会员分组';

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
     * @return mixed
     */
    public function handle()
    {
        echo 111;exit;
    }
}
