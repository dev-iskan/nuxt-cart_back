<?php

namespace App\Scoping;

use App\Scoping\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Scoper {
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder, array $scopes) {
        foreach ($this->limitScopes($scopes) as $key  => $scope) {
            if (!$scope instanceof Scope) {
                continue;
            }
            $scope->apply($builder, $this->request->get($key));
        }

        return $builder;
    }

    protected function limitScopes(array $scopes) {
        //  pluck only thus keys which exits in request
        // if not skip it
        // if we have category then scope it, else skip and return builder
        return array_only(
            $scopes,
            array_keys($this->request->all())
        );
    }
}