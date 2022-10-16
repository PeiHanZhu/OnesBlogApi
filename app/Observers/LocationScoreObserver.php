<?php

namespace App\Observers;

use App\Models\LocationScore;

class LocationScoreObserver
{
    /**
     * Handle the LocationScore "created" event.
     *
     * @param  \App\Models\LocationScore  $locationScore
     * @return void
     */
    public function created(LocationScore $locationScore)
    {
        $this->updateLocationAvgScore($locationScore);
    }

    /**
     * Handle the LocationScore "updated" event.
     *
     * @param  \App\Models\LocationScore  $locationScore
     * @return void
     */
    public function updated(LocationScore $locationScore)
    {
        $this->updateLocationAvgScore($locationScore);
    }

    /**
     * Handle the LocationScore "deleted" event.
     *
     * @param  \App\Models\LocationScore  $locationScore
     * @return void
     */
    public function deleted(LocationScore $locationScore)
    {
        $this->updateLocationAvgScore($locationScore);
    }

    /**
     * Handle the LocationScore "restored" event.
     *
     * @param  \App\Models\LocationScore  $locationScore
     * @return void
     */
    public function restored(LocationScore $locationScore)
    {
        //
    }

    /**
     * Handle the LocationScore "force deleted" event.
     *
     * @param  \App\Models\LocationScore  $locationScore
     * @return void
     */
    public function forceDeleted(LocationScore $locationScore)
    {
        //
    }

    /**
     * Update the avgScore of Location for the LocationScore.
     *
     * @param  \App\Models\LocationScore  $locationScore
     */
    protected function updateLocationAvgScore(LocationScore $locationScore)
    {
        ($location = $locationScore->location)->update([
            'avgScore' => $location->locationScores()->avg('score') ?? 0,
        ]);
    }
}
