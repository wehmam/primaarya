<?php

namespace App\Listeners;

use App\Services\ActivityService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Activitylog\Contracts\Activity;

class LogSuccessfulLogout
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // ActivityService::activityLogs('L', 'Logout');
        // activity()
        //     ->causedBy($event->user)
        //     ->tap(function(Activity $activity) {
        //         $activity->description = 'Logout';
        //         $activity->log_name = 'L';
        //         $activity->save();
        //     });
    }
}
