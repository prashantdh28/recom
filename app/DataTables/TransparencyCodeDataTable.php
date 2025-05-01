<?php

namespace App\DataTables;

use App\Enums\TransparencyCodeHistoryStatusEnum;
use App\Models\TransparencyCode;
use App\Models\TransparencyGtinCodeHistory;
use App\Services\QueryBuilderService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TransparencyCodeDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<TransparencyCode> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setTotalRecords($query->count('id'))
            ->status()
            ->action(function ($value) {
                $link = route('transparency-code.download', ['id' => $value->id]);
                return ($value->status == TransparencyCodeHistoryStatusEnum::getIntegerValue(TransparencyCodeHistoryStatusEnum::SUCCESS)) ? view('transparency.gtin-code.action', compact(['link'])) : '-';
            })
            ->badge('status', function ($value) {
                return view('transparency.gtin-code.status-badge')->with('label', TransparencyCodeHistoryStatusEnum::fromInt($value->status ?? 0));
            });
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<TransparencyCode>
     */
    public function query(TransparencyGtinCodeHistory $model): QueryBuilder
    {
        $model = $model->newQuery();

        $queryBuilderService = new QueryBuilderService($model);

        return $queryBuilderService->search(['gtin', 'sku', 'job_id'])
            ->filter()
            ->getQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('transparencycode-table')
            ->columns($this->getColumns())
            ->ajax([
                'data' => 'function(d) {
                            d.search = $.trim($("input[type=\'search\']").val());
                            d.status = $.trim($("select[name=\'status\']").val());
                        }'
            ])
            ->parameters([
                "dom" => "<'bg-white lg:rounded-t-lg rounded-b-lg border'<'lg:rounded-t-lg overflow-hidden't><'px-3 py-[10px] border-top table-footer bg-white border-t rounded-b-lg'<'flex flex-wrap justify-between gy-3 my-auto'<'flex items-center justify-center md:justify-start'<'mr-3'i>l><'flex align-center justify-center md:justify-end'p>>>",
                // "dom" => "<'rounded-t-xl border-x border-t overflow-hidden't><'p-4 table-footer border rounded-b-xl'<'flex flex-wrap justify-between gy-3'<'flex items-center justify-center md:justify-start gap-3'il><'flex align-center justify-center md:justify-end'p>>",
                'processing' => false,
                'scrollY' => '400px',
                'scrollX' => true,
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('gtin')->name("GTIN")->sortable(false),
            Column::make('sku')->sortable(false),
            Column::make('fnsku')->name("FNSKU")->sortable(false)->class('text-left'),
            Column::make('job_id')->sortable(false),
            Column::make('label_type')->sortable(false)->class('text-nowrap'),
            Column::make('location'),
            Column::make('number_of_code')->sortable(false)->class('text-nowrap'),
            Column::make('status')->sortable(false),
            Column::make('error'),
            Column::make('action')->sortable(false)->class('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'TransparencyCode_' . date('YmdHis');
    }
}
