<?php

namespace App\Services\Api;

use App\Models\Account;
use App\Models\ProductList;
use App\Models\TransparencyGtinCodeHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class TransparencyCodeService
{
	public function generateTransparencyJobId($request, $productId, $numberOfCode)
	{
		$transparencyProduct = ProductList::find($productId, ['account_config_id', 'gtin', 'sku']);
		if(!$transparencyProduct) throw new \Exception('Product Record has been not found', 404);

		$getToken = Account::find($transparencyProduct->account_config_id, ['access_token', 'id']);
		if(!$transparencyProduct) throw new \Exception('Product Record has been not found', 404);
		
		$returnResponse = [];
		if (!empty($transparencyProduct)) {

			$data = [
	            "gtin" => $transparencyProduct->gtin,
	            "count" => (int) $numberOfCode
	        ];
			// Log::info('data', $data);
	        
			$response = Http::withToken($getToken->access_token)->asJson()->post(
				'https://sudd5dkvre.execute-api.us-east-1.amazonaws.com/v1/v1.2/serial/sgtin',
				$data
			);

			if($response->status() == 401)
			{
				$token = (new GenerateAccessTokenService())->generateToken($getToken->id);

				$response = Http::withToken($token)
								->asJson()
								->post(
									'https://sudd5dkvre.execute-api.us-east-1.amazonaws.com/v1/v1.2/serial/sgtin',
									$data
								);
			}

			if(!$response->accepted())
			{
				throw new \Exception($response->body(), $response->status());
			}

			$headers = $response->headers() ?? [];

			// $headers = '{"Content-Type":["application/json"],"Content-Length":["0"],"Connection":["keep-alive"],"Date":["Wed, 09 Apr 2025 04:55:53 GMT"],"X-Amzn-Trace-Id":["Root=1-67f5fdd9-3175813767d300fe4d8f570c"],"x-amzn-RequestId":["8788a50f-645e-4282-a63c-9e2917e47e4b"],"x-amz-apigw-id":["IvSaAHrroAMEnLg="],"Location":["https://api.transparency.com/serial/job/CG5795662006136964952"],"X-Cache":["Miss from cloudfront"],"Via":["1.1 6ae9c95a0819def152566a00d31a99be.cloudfront.net (CloudFront)"],"X-Amz-Cf-Pop":["BOM54-P2"],"X-Amz-Cf-Id":["9BkItIknO8eKmuorsRCqD2E7bufWMKWT6D8kKEVnUC73_4JKczosHA=="]}';
			// $headers = json_decode($headers, true);

			if(count($headers) == 0) throw new \Exception('Response Header is missing', 404);

	        $location = null;
			$jobId = null;
			$errorMsg = null;
			
			if (isset($headers['Location']) && isset($headers['Location'][0]))
			{ 
				$location = trim(preg_replace('/(\t|\s)+/', ' ', $headers['Location'][0]));
				$headerArr = explode('/', $location);
				$jobId = end($headerArr);
			}else{
				// $errorMsg = $response->body() ?? 'Response Header Location is missing';
				$errorMsg = 'Response Header Location is missing';
			}
				

	        if (!empty($errorMsg) && empty($jobId)) {
	        	$returnResponse = [
	                'type'   => 'error',
	                'status' => 400,
	                'message' => $errorMsg
	            ];
	        } elseif (!empty($jobId)) {
				$jobIdCount = TransparencyGtinCodeHistory::where('job_id', $jobId)->count();

		        if ($jobIdCount == 0) {
		        	TransparencyGtinCodeHistory::create([
			        	'transparency_product_id' => $productId ?? null,
			        	'job_id' => $jobId,
			        	'location' => $location,
			        	'number_of_code' => $numberOfCode,
			        	'gtin' => $transparencyProduct->gtin ?? null,
			        	'sku' => $transparencyProduct->sku ?? null,
						'fnsku' => $request->fnsku ?? null,
						'label_type' => $request->label_type,
			        	'status' => 0,
			        	'error' => $errorMsg,
			        	'created_by' => Auth::user()->id,
						'updated_by' => Auth::user()->id,
			        ]);

	        		$returnResponse = [
		                'type'   => 'success',
		                'status' => 200,
		                'message' => 'Job Id generated successfully.'
		            ];
		        	
		        } else {
		        	$returnResponse = [
		                'type'   => 'error',
		                'status' => 400,
		                'message' => 'Job Id already exist.'
		            ];
		        }
	        } else {
	        	$returnResponse = [
	                'type'   => 'error',
	                'status' => 400,
	                'message' => 'Job Id not generated.'
	            ];
	        }
	    }

        return $returnResponse;
	}

	public function generateBarcode($id)
	{
		$getTransparencyCodeHistory = $this->getCodeHistory($id);

		if(is_null($getTransparencyCodeHistory->generated_code)) throw new \Exception("Generate code value must not be empty value", 500);

		$generatedCodes = str_replace(array('[', ']'), '', $getTransparencyCodeHistory->generated_code);
		$generatedCodeArr = explode(',', $generatedCodes);
		$htmlData = [];
		$labelType = $getTransparencyCodeHistory->label_type;
		
		if($labelType == 3 || $labelType == 4)
			$productBarcodeData = $this->generateProductLabel($getTransparencyCodeHistory, $labelType);

		$setMethodName = $labelType == 2 || $labelType == 5 ? 1 : ($labelType == 3 ? 4 : $labelType);
		// Dynamically determine the function name
		$methodName = 'generateQRCodeForType' . $setMethodName;

		// Check if the method exists before calling
		if (!method_exists($this, $methodName))  throw new \Exception("Invalid label type provided", 404);
		
		foreach ($generatedCodeArr as $generatedCode) {
			$fileData = $this->$methodName($getTransparencyCodeHistory->job_id, trim($generatedCode, '"'), $labelType);

			$htmlData[] = [
				'labelType' => $labelType,
				'barcodeImage' => $productBarcodeData['barcode_filename'] ?? null,
				'qrCodeImage' => $fileData['filename'],
				'fnsku' => $getTransparencyCodeHistory->fnsku ?? null,
				'title' => $getTransparencyCodeHistory->transparencyProduct->product_name,
				'job_id' => $getTransparencyCodeHistory->job_id,
				'brand' => !empty($getTransparencyCodeHistory->transparencyProduct) ? $getTransparencyCodeHistory->transparencyProduct->brand : '',
				'gtin' => $getTransparencyCodeHistory->gtin
			];
		}
		// $htmlData = $this->generateQRCode();

		Session::put('generatedQRCodeHtml', $htmlData);
		
		return $htmlData;
	}

	/** Get a single record of Transparency Code History */
	public function getCodeHistory($id)
	{
		$history = TransparencyGtinCodeHistory::with(['transparencyProduct' => function ($query){
			$query->select("id","product_file_id","account_config_id", "brand", "product_name");
		}])->where('id', $id)->first();

		if (empty($history)) throw new \Illuminate\Support\ItemNotFoundException("Record not found!");

		return $history;
	}

	/** Generate Product label for particular Job ID
	 * @param TransparencyGtinCodeHistory $transparencyHistory
	 */
	public function generateProductLabel(TransparencyGtinCodeHistory $transparencyHistory, $labelType) : array
    {
        $fileData = [];
		
		$filePath = 'uploads/qr_code/'.$transparencyHistory->job_id.'/product_barcode/';

		// dd(Storage::exists($filePath));
		if (!Storage::disk('public')->exists($filePath)) {
			$isDirectoryCreate = Storage::disk('public')->makeDirectory($filePath, 0777, true); //creates directory
			if(!$isDirectoryCreate) throw new \Exception("Directory not created", 500);
		}

		$targetPath = storage_path("app/public/".$filePath);

		$fnsku = $transparencyHistory->fnsku;
		$barcode = new \Com\Tecnick\Barcode\Barcode();
		
		$width = $labelType == 4 ? 160 : 120;
		$height = $labelType == 4 ? 30 : 25;
		$bobj = $barcode->getBarcodeObj('C128A', $fnsku, $width, $height, 'black', array(0,0,0,0))->setBackgroundColor('white');

		$imageData      = $bobj->getSvgCode();
		$timestamp      = time();
		$filename       = $transparencyHistory->job_id.'_'.$fnsku.'_'.$timestamp . '.svg';
		$filepath       = $targetPath . $filename;                
		file_put_contents($filepath, $imageData);
		
		//prepare response data
		$fileData['barcode_filepath'] = $filepath;
		$fileData['barcode_filename'] = $filename;
			
        return $fileData; 
    }

	/** Generate Product label for particular Job ID
	 * @param TransparencyGtinCodeHistory $transparencyHistory
	 */
	public function generateQRCodeForType4($jobId, $code, $labelType) : array
    {
        $fileData = [];
		$codeArr = explode(':', $code);

		$filePath = 'uploads/qr_code/'.$jobId.'/';

		if (!Storage::disk('public')->exists($filePath)) {
			$isDirectoryCreate = Storage::disk('public')->makeDirectory($filePath, 0777, true); //creates directory
			if(!$isDirectoryCreate) throw new \Exception("Directory not created", 500);
		}

		$targetPath = storage_path("app/public/".$filePath);

		$barcode = new \Com\Tecnick\Barcode\Barcode();

		$bobj = $barcode->getBarcodeObj(
				'DATAMATRIX',                     // barcode type and additional comma-separated parameters
				$code,                          // data string to encode
				53,
				53,          // bar height (use absolute or negative value as multiplication factor)
				'black',                        // foreground color
				array(-2, -2, -2, -2)           // padding (use absolute or negative values as multiplication factors)
				)->setBackgroundColor('white'); // background color

		$imageData      = $bobj->getSvgCode();
		$timestamp      = time();
		$filename       = $codeArr[1].'_'.$timestamp . '.svg';
		$filepath       = $targetPath . $filename; 

		file_put_contents($filepath, $imageData);

		//prepare response data
		$fileData['filepath'] = $filepath;
		$fileData['filename'] = $filename;

        return $fileData;        
    }

	/** Generate Product label for Label Type 1 & Label Type 2
	 * @param TransparencyGtinCodeHistory $transparencyHistory
	 */
	public function generateQRCodeForType1($jobId, $code, $labelType) : array
    {
        $fileData = [];
		$codeArr = explode(':', $code);

		$filePath = 'uploads/qr_code/'.$jobId.'/';

		if (!Storage::disk('public')->exists($filePath)) {
			$isDirectoryCreate = Storage::disk('public')->makeDirectory($filePath, 0777, true); //creates directory
			if(!$isDirectoryCreate) throw new \Exception("Directory not created", 500);
		}

		$targetPath = storage_path("app/public/".$filePath);

		$barcode = new \Com\Tecnick\Barcode\Barcode();

		$widthHeight = ($labelType == 5) ? 70 : 50;

		$bobj = $barcode->getBarcodeObj(
				'DATAMATRIX',                     // barcode type and additional comma-separated parameters
				$code,                          // data string to encode
				$widthHeight,
				$widthHeight,          // bar height (use absolute or negative value as multiplication factor)
				'black',                        // foreground color
				array(-2, -2, -2, -2)           // padding (use absolute or negative values as multiplication factors)
				)->setBackgroundColor('white'); // background color

		$imageData      = $bobj->getSvgCode();
		$timestamp      = time();
		$filename       = $codeArr[1].'_'.$timestamp . '.svg';
		$filepath       = $targetPath . $filename; 

		file_put_contents($filepath, $imageData);

		//prepare response data
		$fileData['filepath'] = $filepath;
		$fileData['filename'] = $filename;

        return $fileData;        
    }

	// /** Generate Product label for particular Job ID
	//  * @param TransparencyGtinCodeHistory $transparencyHistory
	//  */
	// public function generateQRCodeImage($jobId, $code) : array
    // {
    //     $fileData = [];
	// 	$codeArr = explode(':', $code);

	// 	$filePath = 'uploads/qr_code/'.$jobId.'/';

	// 	if (!Storage::disk('public')->exists($filePath)) {
	// 		$isDirectoryCreate = Storage::disk('public')->makeDirectory($filePath, 0777, true); //creates directory
	// 		if(!$isDirectoryCreate) throw new \Exception("Directory not created", 500);
	// 	}

	// 	$targetPath = storage_path("app/public/".$filePath);

	// 	$barcode = new \Com\Tecnick\Barcode\Barcode();

	// 	$bobj = $barcode->getBarcodeObj(
	// 			'DATAMATRIX',                     // barcode type and additional comma-separated parameters
	// 			$code,                          // data string to encode
	// 			70,
	// 			70,          // bar height (use absolute or negative value as multiplication factor)
	// 			'black',                        // foreground color
	// 			array(-2, -2, -2, -2)           // padding (use absolute or negative values as multiplication factors)
	// 			)->setBackgroundColor('white'); // background color

	// 	$imageData      = $bobj->getSvgCode();
	// 	$timestamp      = time();
	// 	$filename       = $codeArr[1].'_'.$timestamp . '.svg';
	// 	$filepath       = $targetPath . $filename; 

	// 	file_put_contents($filepath, $imageData);

	// 	//prepare response data
	// 	$fileData['filepath'] = $filepath;
	// 	$fileData['filename'] = $filename;

    //     return $fileData;        
    // }
}
