<?php

namespace App\Listeners;

use App\Events\UpdateCustomerGroup;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateCustomerGroupListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UpdateCustomerGroup  $event
     * @return void
     */
    public function handle(UpdateCustomerGroup $event)
    {
        //
    }
}
