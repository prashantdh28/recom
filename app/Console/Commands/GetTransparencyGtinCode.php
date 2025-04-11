<?php

namespace App\Console\Commands;

use App\Enums\TransparencyCodeHistoryStatusEnum;
use App\Events\CommandFailed;
use App\Helpers\CommonHelper;
use App\Helpers\TransparencyApiHelper;
use App\Models\Account;
use App\Models\CronLog;
use App\Models\CronErrorLog;
use App\Models\Store;
use App\Models\TransparencyAccountConfig;
use App\Models\TransparencyGtinCodeHistory;
use App\Models\TransparencyProduct;
use App\Services\Api\GenerateAccessTokenService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GetTransparencyGtinCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transparency:get-gtin-code {record_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get transparency gtin code api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $recordId = $this->argument('record_id');
            $this->fetchTransparencyGtinCode($recordId);
        } catch (\Exception $e) {
            dispatch(new CommandFailed($this, $e->getMessage()));
        }
    }

    protected function fetchTransparencyGtinCode($recordId)
    {
        $pendingCode = TransparencyGtinCodeHistory::with(['transparencyProduct' => function($query) {
                                $query->select('id', 'account_config_id');
                            }])->when($recordId, function($query) use($recordId) {
                                $query->where('id', $recordId);
                            })->where('status', 0)->first();

        if(!$pendingCode || !$pendingCode->transparencyProduct) throw new \Exception('Record is missing', 404);

        $getToken = Account::find($pendingCode->transparencyProduct->account_config_id, ['access_token', 'id']);
            
        $response = Http::withToken($getToken->access_token)
                        ->asJson()
                        ->get('https://sudd5dkvre.execute-api.us-east-1.amazonaws.com/v1/v1.2/serial/job/' . $pendingCode->job_id);

        if($response->status() == 401)
        {
            $token = (new GenerateAccessTokenService())->generateToken($getToken->id);

            $response = Http::withToken($token)
                        ->asJson()
                        ->get('https://sudd5dkvre.execute-api.us-east-1.amazonaws.com/v1/v1.2/serial/job/' . $pendingCode->job_id);
        }

        cache()->put('job_id_test', $response->body(), 3600);
        $jobResponseArr = $response->body() ? json_decode($response->body(), true) : [];

        // $response = '{"url":"https://tpncy-serial-generation-artifacts.s3.amazonaws.com/TCodes_CG5795662006136964952_NEST02CWS008_00840732131227?X-Amz-Security-Token=IQoJb3JpZ2luX2VjEBQaCXVzLWVhc3QtMSJIMEYCIQCRwyqLFCjIW3GyoL7J9YSPm7S7YyZFsCES65AU1TxBFgIhAIvwadFFvk0UwtTUbAeJzhRAsToo%2B%2BzGKzVqHRXG7BxYKtoECI3%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEQAhoMMDI3MjM4NjY0ODAyIgzILAxb5GAmxvpdytQqrgSdTf7QPS4PubZG71lQDAoyiMKJWf6tt%2BR8Ufr3K9jqsm6%2B7bYIehuHCglr52t%2B%2BE8p6h6gFIuu7NtpWoQl8P1kmiLMSuJXit%2FZFK6Ag1%2Bibbgh566MOCkrYPhpuChAHH0F7SUQhfoCbE163KComLGZZMFE%2F7%2Be4gqlMBOoWwhKa0OvbUhDKfw3CA7bL6JUcN8fKHPhHoel7v5tCpELmEjnSTkw7dGJZk5tp6uRCOCsf%2BogU7DxjxQG1jHvKEBPdXEi5N91XhgSDWWZviI4i8hCwMUiDEdYs8Yqg%2BAKG3V%2FUPVidB7HoPe0laFZyvg244KejE9Cl6i6y5aFCmVuExHScpf1s5iZSD3l3xejQUMszyJbiI%2B2G8Y7Uc7iZ7SSYNH7nBhmrhh2NK2vtXc8LPhZhb0Kmx3IYbVv5mUYclgBjPbJzisbcsisxHhq4ru4d4G3al8WwcchxYzG%2Fey9FVqDDnI8lU%2Bi9Ed5XeXdeVhTFsY0E4bLxsa36I85UPM%2F1DjU3aMHNztenXfDo72fbw1d6%2FUwvgluXxcsfT6gO41qrHEdKw011c63ryO%2FzW8h3EIt1yisgeDyUuuyGB2ZjWRIgKNGlTm%2Bn0x%2FaQnSPu5CdmiMA6IITGvFvTwpskxd0lcOquc%2BoWeTbl6fS1S1VYDHC0wKKWoPVS5wQbQ8bkbn%2BC21k0mUvFpfoMPAXV2v5GKKaS2FaHPDSLKaVaZE3kG2ta28yzEY9OBPSlVBL%2FswubfZvwY6pgHQWVel7Fim9O3rVe91GgOsEh%2FJqtM%2Fs4XUvQyEO6WU%2F9P%2BBGF%2F1LPUKgcQZl%2F26VTD8rzaU1bO4bKqmS1jpgw0g8gIsTJVsgg6bblK6OmjJ2KmHEr4%2BW%2FdBwNu4PTLfY3V223ZV8QklFIRSRrW5qp%2B0w1LcULaFquhEOg%2FOosyywD8JWwSglUh8pv8iBw9mGeHWxccXnIcdiV%2FfKZSaSYV%2BP4GRkp7&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Date=20250409T121500Z&X-Amz-SignedHeaders=host&X-Amz-Expires=3600&X-Amz-Credential=ASIAQMV4NBJRMWJFZNKT%2F20250409%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Signature=97791c459251e8595cf8906268e9de394fff7c8deae9c919a7a620b675141b1f","status":"COMPLETED","error":null}';
        // $jobResponseArr = json_decode($response, true);

        if (isset($jobResponseArr['error']) && !empty($jobResponseArr['error'])) {
            $pendingCode->status = TransparencyCodeHistoryStatusEnum::getIntegerValue(TransparencyCodeHistoryStatusEnum::ERROR);
            $pendingCode->error = $jobResponseArr['error'];
            $pendingCode->save();
        } elseif (isset($jobResponseArr['status']) && $jobResponseArr['status'] == 'COMPLETED' && isset($jobResponseArr['url'])) {
            //download report
            $downloadDocumentResponse = self::downloadDocument($jobResponseArr['url'], $pendingCode->job_id);

            $responseArr = json_decode($downloadDocumentResponse, true);

            if(isset($responseArr['codesList']) && !empty($responseArr['codesList'])){
                $codes = json_encode($responseArr['codesList'][0]['codes']);
                $pendingCode->generated_code = $codes;
                $pendingCode->status = TransparencyCodeHistoryStatusEnum::getIntegerValue(TransparencyCodeHistoryStatusEnum::SUCCESS);
                $pendingCode->save();
            }
        }
    }

    private static function downloadDocument($url, $jobId)
    {
        $reportData = [];
        if (!empty($url) && !empty($jobId)) {
            // $reportData = file_get_contents($url);
            $getContents = Http::get($url); // Download the schema using the schema url.

            if($getContents->successful())
            {
                $reportData = self::extractFileContent($getContents, $jobId);
            }
        }
        
        return $reportData ?? [];
    }

    private static function extractFileContent($file_content, $jobId)
    {
        // dd(Storage::disk('public')->exists('transparency_gtin_code/amazon/'));
        if (!Storage::disk('public')->exists('transparency_gtin_code/amazon/')) {
            Storage::disk('public')->makeDirectory('transparency_gtin_code/amazon/', 0777, true);
            print("storage");
        }
        $report_folder = storage_path("app/public/transparency_gtin_code/amazon/");
        $zipFile = $report_folder . $jobId . '.gz';
        $feedHandle = fopen($zipFile, 'w');
        fclose($feedHandle);
        $feedHandle = fopen($zipFile, 'rw+');
        fwrite($feedHandle, $file_content);
        $gz = gzopen($zipFile, 'rb');
        $file_name = $report_folder . $jobId . '.xls';
        $dest = fopen($file_name, 'wb');
        stream_copy_to_stream($gz, $dest);
        gzclose($gz);
        fclose($dest);
        $report_data = file_get_contents($file_name);

        if (Storage::disk('public')->exists('transparency_gtin_code/amazon/' . $jobId . '.gz')) {
            Storage::disk('public')->delete('transparency_gtin_code/amazon/' . $jobId . '.gz');
        }
    
        return $report_data;
    }
}
