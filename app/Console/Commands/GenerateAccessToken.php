<?php

namespace App\Console\Commands;

use App\Services\Api\GenerateAccessTokenService;
use Illuminate\Console\Command;

class GenerateAccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transparency:generate-access-token {--account_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the access token for Amazon Trnasparency Account';

    /**
     * Execute the console command.
     */
    public function handle(GenerateAccessTokenService $generateAccessTokenService)
    {
        try {
            $accountId = $this->option('account_id');

            /** Check the Account ID value is valid or not */
            if (!is_numeric($accountId) || (int) $accountId <= 0) {
                throw new \InvalidArgumentException('The "account_id" must be a valid positive integer.');
            }

            $generateAccessTokenService->generateToken((int) $accountId); /** Generate Token */
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
