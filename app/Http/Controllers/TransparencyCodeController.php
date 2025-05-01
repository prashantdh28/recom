<?php

namespace App\Http\Controllers;

use App\DataTables\TransparencyCodeDataTable;
use App\Enums\TransparencyCodeHistoryStatusEnum;
use App\Services\Api\TransparencyCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class TransparencyCodeController extends Controller
{
    /**
     * Generated Transparency Code List.
     */
    public function index(Request $request, TransparencyCodeDataTable $accountDatatable)
    {
        $status = !$request->ajax() ? TransparencyCodeHistoryStatusEnum::getStatus() : [];

        return $accountDatatable->render("transparency.gtin-code.index", compact('status'));
    }

    /**
     * Generate Transparency Code.
     */
    public function generateTransparencyCode(Request $request, TransparencyCodeService $transparencyCodeService)
    {
        try {
            if(is_null($request->transparency_product_id)) return redirect()->route('product-file.index')->with('error', 'Product not Found.');

            $productId = Crypt::decrypt($request->transparency_product_id);
            $generateJobId = $transparencyCodeService->generateTransparencyJobId($request, $productId, $request->number_of_code);
            return redirect()->route('product-list.index')->with('success', $generateJobId['message']);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('product-list.index')->with('error', $e->getMessage());
        }
    }

    /** Generate Barcode & Download it */
    public function generateBarcode($id, TransparencyCodeService $transparencyCodeService)
    {
        try {
            if (Session::has('generatedQRCodeHtml')) Session::forget('generatedQRCodeHtml');
    
            $generatBarcode = $transparencyCodeService->generateBarcode($id);

            if($generatBarcode){
                return response()->json([
                    'type'   => 'success',
                    'status' => 200,
                    'message' => 'Transparency code download successfully',
                ]);
            }
            
            return response()->json([
                'type'   => 'error',
                'status' => 500,
                'message' => 'Something went wrong.',
            ]);
        } catch(\Illuminate\Support\ItemNotFoundException $notFoundException) {
            return response()->json([
                'type'   => 'success',
                'status' => 404,
                'message' => $notFoundException->getMessage(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'type'   => 'error',
                'status' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function generateQRCodeHtml()
    {
        $htmlData = Session::get('generatedQRCodeHtml');
        
        $view = 'qr-code';
        if($htmlData[0]['labelType'] != 4)
        {
            $view = 'type'.$htmlData[0]['labelType'];
            return view("transparency.gtin-code.qr-code/$view", compact('htmlData'));
        }
        return view("transparency.gtin-code.$view", compact('htmlData'));
    }
}
