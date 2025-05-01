<?php

namespace App\Http\Controllers;

use App\DataTables\ProductListDataTable;
use App\Enums\ProductListEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductListController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, ProductListDataTable $productListDataTable)
    {
        // Session::forget('job_id_20');
        // $value = Session::get('job_id_20');
        // dd($value);
        // dd($value->status());
        try {
            $status = !$request->ajax() ? ProductListEnum::cases() : [];
            return $productListDataTable->render('transparency.product-list.index', compact('status'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
