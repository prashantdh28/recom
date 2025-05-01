<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CommonStatusController extends Controller
{
    /**
     * Toggle the status into the database.
     */
    public function __invoke(Request $request)
    {
        try {
            $id = Crypt::decrypt($request->id);
            $modelClass = 'App\\Models\\' . $request->module;
            $getRecord = null;

            if (!class_exists($modelClass)) return response()->json(['status' => true, 'message' => 'Model not found'], 404);

            $getRecord = $modelClass::find($id);

            if(!$getRecord) return response()->json(['status' => true, 'message' => 'Record is not found'], 404);

            $getRecord->update(['status' => !$getRecord->status]);
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
