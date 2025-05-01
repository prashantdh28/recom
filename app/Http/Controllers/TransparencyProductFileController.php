<?php

namespace App\Http\Controllers;

use App\DataTables\TransparencyProductFileDataTable;
use App\Enums\ProductFileEnum;
use App\Http\Requests\StoreTransparencyProductFileRequest;
use App\Jobs\ProcessProductFileImportJob;
use App\Models\TransparencyProductFile;
use App\Services\ProductFileService;
use App\Traits\AccountConfigTrait;
use Illuminate\Http\Request;

class TransparencyProductFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, TransparencyProductFileDataTable $transparencyProductFileDataTable)
    {
        // if($request->ajax())
        // {
        //     dispatch(new ProcessProductFileImportJob());
        // }
        $status = !$request->ajax() ? ProductFileEnum::getAllStatus() : [];
        return $transparencyProductFileDataTable->render('transparency.product-file.index', compact('status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ProductFileService $productFileService)
    {
        $accounts = $productFileService->getAccounts();
        return view('transparency.product-file.create', compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransparencyProductFileRequest $request)
    {
        try {
            $file = $request->file('file_name');
            $fileName = $file->getClientOriginalName();
            $storeFile = $file->storeAs('transparency/product-files', $fileName, 'public');

            if(!$storeFile) return redirect()->route('product-file.index')->with('error', 'Something went wrong');

            TransparencyProductFile::create(['file_name' => $fileName, 'user_id' => auth()->user()->id] + $request->validated());
            dispatch(new ProcessProductFileImportJob());
            return redirect()->route("product-file.index")->with('success', 'Product File Uploaded Successfully');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('product-file.index')->with('error', $e->getMessage());
        }
    }
}
