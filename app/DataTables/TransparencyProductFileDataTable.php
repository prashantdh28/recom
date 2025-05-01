<?php

namespace App\DataTables;

use App\Enums\ProductFileEnum;
use App\Models\TransparencyProductFile;
use App\Services\QueryBuilderService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TransparencyProductFileDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setTotalRecords($query->count('id'))
            ->status()
            ->badge('processing_status', function($value){
                return view('transparency.product-file.processing-status-badge')->with('label', ProductFileEnum::fromInt($value->processing_status ?? 0));
            })
            ->modifyDate()
            ->action(function($value){
                return ($value->error_file_name) ? view('transparency.product-file.error-file')
                    ->with('link', Storage::disk('public')->url("transparency/product-files/errors/$value->error_file_name")) : '-';
            })
            ->filter(function ($query) {
                if (request()->has('search') && request('search')) {
                    $search = request('search');
                    
                    $query->where(function($q) use ($search) {
                        $q->whereHas('account', function($q) use ($search) {
                              $q->where('name', 'like', "%{$search}%");
                          });
                    });
                }
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(TransparencyProductFile $model): QueryBuilder
    {
        $model = $model->newQuery()->with(['account:name,id', 'user:name,id']);

        $queryBuilderService = new QueryBuilderService($model);

        return $queryBuilderService->filter('processing_status')
                        ->getQuery();
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
                            d.processing_status = $.trim($("select[name=\'status\']").val());
                        }'
                    ])
                    ->parameters([
                        "dom" => "<'bg-white lg:rounded-t-lg rounded-b-lg border'<'lg:rounded-t-lg overflow-hidden't><'px-3 py-[10px] border-top table-footer bg-white border-t rounded-b-lg'<'flex flex-wrap justify-between gy-3 my-auto'<'flex items-center justify-center md:justify-start'<'mr-3'i>l><'flex align-center justify-center md:justify-end'p>>>",
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
            Column::make('account.name')->sortable(false),
            Column::make('file_name')->sortable(false),
            Column::make('processing_status')->sortable(false),
            Column::make('user.name')->sortable(false),
            Column::make('created_at')->sortable(false),
            Column::make('action')->sortable(false)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'TransparencyProductFile_' . date('YmdHis');
    }
}
