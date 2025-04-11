<?php

namespace App\Events;

use App\Models\CronLog;
use Illuminate\Console\Command;
use Illuminate\Foundation\Events\Dispatchable;

class CommandFailed
{
    use Dispatchable;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Command $command,
        public ?string $error
    )
    {
        
    }

    public function __invoke()
    {
        $logId = cache()->pull("artisan_log_{$this->command->getName()}");

        if ($logId && $log = CronLog::find($logId)) {
            $log->update([
                'status' => "2",
                'error_msg' => $this->error
            ]);
        }

        cache()->forget("artisan_log_{$this->command->getName()}");
    }
}
