<?php

namespace App\Providers;

use App\Models\CronLog;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(CommandStarting::class, function(CommandStarting $event) {
            if(str()->startsWith($event->command, 'transparency'))
            {
                $arguments = $event->input->getArguments();
                if($arguments)
                {
                    unset($arguments['command']);
                }
                
                $log = CronLog::create([
                    'name' => $event->command,
                    'arguments' => $arguments,
                    'status' => "0",
                ]);
        
                cache()->put("artisan_log_{$event->command}", $log->id, 900);
            }
        });

        Event::listen(CommandFinished::class, function(CommandFinished $event){
            if(str()->startsWith($event->command, 'transparency'))
            {
                $logId = cache()->pull("artisan_log_{$event->command}");
                if ($logId && $log = CronLog::find($logId))
                {
                    $log->update([
                        'status' => "1"
                    ]);
                }
                cache()->forget("artisan_log_{$event->command}");
            }
        });
    }
}
