<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class UserEloquentProvider extends EloquentUserProvider
{
    public function __construct(HasherContract $hasher, $model)
    {
        $this->hasher = $hasher;
        $this->model = $model;
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
    }

    public function retrieveById($identifier)
    {
        $model = parent::createModel();

        return parent::newModelQuery($model)
                    ->where($model->getAuthIdentifierName(), $identifier)
                    ->select('id', 'name')
                    ->first();
    }
}
