<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class QueryBuilderService
{
    protected Builder $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function search(array $fields = ['name']) : self
    {
        $this->builder->when(request()->has('search') && request('search'), function($sql)  use ($fields) {
            $sql->where(function ($query) use ($fields) {
                if (request()->has('search') && $fields) {
                    foreach ($fields as $key => $field) {
                        if ($key == 0) {
                            $query->where($field, 'like', "%" . request('search') . "%");
                        } else {
                            $query->orWhere($field, 'like', "%" . request('search') . "%");
                        }
                    }
                }
            });
        });
        return $this;
    }

    public function filter(string $field = 'status', string $operator = '=') : self
    {
        $this->builder->when(request()->has($field) && (request($field) || request($field) == "0"), function ($query) use ($field, $operator) {
            $query->where($field, $operator, request($field));
        });
        return $this;
    }

    public function getQuery() : Builder
    {
        return $this->builder;
    }
}
