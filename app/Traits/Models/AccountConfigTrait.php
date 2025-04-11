<?php

namespace App\Traits\Models;

use App\Models\Account;

trait AccountConfigTrait
{
    /**
     * Get Specific Account Config Record.
     * @param int $accountId, array $fields
     */
    public function getAccount(int $accountId, array $fields = []) : Account
    {
        if($fields) return Account::find($accountId, [...$fields]);

        return Account::find($accountId);
    }
}
