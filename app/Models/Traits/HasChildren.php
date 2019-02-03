<?php

namespace App\Models\Traits;

trait HasChildren {

    public function scopeParents ($builder) {
        $builder->whereNull('parent_id');
    }
}