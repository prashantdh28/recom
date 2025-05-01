<?php

namespace App\Providers;

use App\Enums\AccountConfigEnum;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Yajra\DataTables\EloquentDataTable;

class DataTableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /**
         *  Macro Service for Status field.
         */
        EloquentDataTable::macro('status', function(){
            return $this->editColumn('status', function($value){
                return view('components.switch')->with('value', $value->status);
            });
        });

        /**
         * Macro Service for Badge Field.
         * @param string $field, callable $callback
         */
        EloquentDataTable::macro('badge', function(string $field, ?callable $callback = null){
            return $this->editColumn($field, function($value) use($callback){
                return $callback ? $callback($value) : view('transparency.account-config.api-status-badge')->with('label', AccountConfigEnum::fromInt($value->api_status ?? 0));
            });
        });

        /**
         * Macro Service for Action Column.
         * @param callable $callback
         */
        EloquentDataTable::macro('action', function(?callable $callback = null){
            return $this->addColumn('action', function($value) use($callback){
                return $callback ? $callback($value) : '-';
            });
        });

        /**
         * Macro Service for Modify Date like Change the date format.
         * @param string $field, string $format
         */
        EloquentDataTable::macro('modifyDate', function(string $field = 'created_at', ?string $format = null){
            return $this->editColumn($field, function($value) use($field, $format){
                $format = $format ?? config('common.date_time_format');
                return ($value) ? Carbon::parse($value->$field)->format($format) : '-';
            });
        });
    }
}
