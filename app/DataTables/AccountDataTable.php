<?php

namespace App\DataTables;

use App\Models\Account;
use App\Services\QueryBuilderService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AccountDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query)
    {
        return (new EloquentDataTable($query))
            ->setTotalRecords($query->count('id'))
            ->setRowId(function($value){
                return Crypt::encrypt($value->id);
            })
            ->status()
            ->badge('api_status')
            ->modifyDate()
            ->action(function($value){
                $editLink = route('account-config.edit', ['account_config' => $value->id]);
                // $deleteLink = route('account-config.destroy', ['account_config' => $value->id]);
                return view('components.action', compact(['editLink']));
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Account $model): QueryBuilder
    {
        $model = $model->newQuery();

        $queryBuilderService = new QueryBuilderService($model);

        return $queryBuilderService->search(['name', 'client_id'])
                    ->filter()
                    ->getQuery();
        // return $model->newQuery()
        //             ->search(['name', 'client_id']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('account-table')
                    ->columns($this->getColumns())
                    ->ajax([
                        'data' => 'function(d) {
                            d.search = $.trim($("input[type=\'search\']").val());
                            d.status = $.trim($("select[name=\'status\']").val());
                        }'
                    ])
                    ->parameters([
                        "dom" => "<'rounded-t-xl border-x border-t overflow-hidden't><'p-4 table-footer border rounded-b-xl'<'flex flex-wrap justify-between gy-3'<'flex items-center justify-center md:justify-start gap-3'il><'flex align-center justify-center md:justify-end'p>>",
                    ])
                    ->orderBy(3);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('name'),
            Column::make('client_id'),
            Column::make('api_status'),
            Column::make('created_at'),
            Column::make('token_updated'),
            Column::make('status'),
            Column::make('action')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Account_' . date('YmdHis');
    }
}
