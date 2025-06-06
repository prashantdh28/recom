<?php

namespace App\DataTables;

use App\Enums\ProductListEnum;
use App\Models\ProductList;
use App\Services\QueryBuilderService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductListDataTable extends DataTable
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
            ->badge('product_status', function($value){
                return view('transparency.product-list.product-status')->with('label', ProductListEnum::tryFrom($value->product_status));
            })
            ->action(function($value){
                $id = Crypt::encrypt($value->id);
                return view('components.modal', compact(['id', 'value']));
            })
            ->modifyDate();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductList $model): QueryBuilder
    {
        $model = $model->newQuery();

        $queryBuilderService = new QueryBuilderService($model);

        return $queryBuilderService->search(['gtin', 'asin', 'sku'])
                    ->filter('product_status')
                    ->getQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('product-list-table')
                    ->columns($this->getColumns())
                    ->ajax([
                        'data' => 'function(d) {
                            d.search = $.trim($("input[type=\'search\']").val());
                            d.product_status = $.trim($("select[name=\'status\']").val());
                        }'
                    ])
                    ->parameters([
                        "dom" => "<'bg-white lg:rounded-t-lg rounded-b-lg border'<'lg:rounded-t-lg overflow-hidden't><'px-3 py-[10px] border-top table-footer bg-white border-t rounded-b-lg'<'flex flex-wrap justify-between gy-3 my-auto'<'flex items-center justify-center md:justify-start'<'mr-3'i>l><'flex align-center justify-center md:justify-end'p>>>",
                        'processing' => false,
                        'scrollY' => '400px',
                        'scrollX' => true,
                    ])
                    ->orderBy(6);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('brand')->sortable(false),
            Column::make('product_name')->sortable(false),
            Column::make('gtin')->sortable(false),
            Column::make('sku')->sortable(false),
            Column::make('asin')->sortable(false),
            Column::make('product_status')->sortable(false),
            Column::make('created_at')->sortable(false),
            Column::make('action')->sortable(false)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProductList_' . date('YmdHis');
    }
}
