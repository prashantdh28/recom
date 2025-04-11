<?php

namespace App\Traits;

use App\Enums\StatusEnum;

trait AccountConfigTrait
{
    public function getAllStatus() : array
    {
        return StatusEnum::getStatus();
    }
}
