<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Activitylog\Contracts\Activity;

class LogSuccessfulLogin
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
        activity()
            ->causedBy($event->user)
            ->tap(function(Activity $activity) {
                $activity->description = 'Berhasil Login';
                $activity->log_name = 'B';
                $activity->save();
            });

    }
}
