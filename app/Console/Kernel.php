<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Log;
use App\Models\Hosts;
use App\Models\Properties;
use App\Models\Ratings;
use App\Models\Bookings;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        $hosts = Hosts::get();

        foreach ($hosts as $key => $host) {

            if(Carbon::now() > $host->planEndDate){
                if($host->trial == 1){
                    $host->trial = 0;
                }
                $host->siteVizibility = 0;
                $host->save();

                Properties::where('hostId', $host->id)->update(['siteVizibility' => 0]);
            }
        }


        $ratings = Ratings::get();
        $ratingsProperties = [];
        foreach ($ratings as $key => $rating) {
            if(!isset($ratingsProperties[$rating->propertyId])){
                $ratingsProperties[$rating->propertyId] = [
                    'rating' => 0,
                    'count' => 0
                ];
            }

            $ratingsProperties[$rating->propertyId]['rating'] += $rating->overall;
            $ratingsProperties[$rating->propertyId]['count']++;
        }

        foreach ($ratingsProperties as $propertyId => $ratingData) {
            $newPropertyRating = round($ratingData['rating'] / $ratingData['count'] * 2) / 2;
            Properties::where('id', $propertyId)->update(['rating' => $newPropertyRating]);
        }

        $bookings = Bookings::get();
        foreach ($bookings as $propertyId => $booking) {
            if($booking->startDate == Carbon::today()->toDateString()){
                $booking->status = 'ongoing';
                $booking->save();
            }
            if($booking->endDate == Carbon::today()->toDateString()){
                $booking->status = 'complete';
                $booking->save();
            }
        }

        require base_path('routes/console.php');
    }
}
