<?php

namespace App\Models\Traits;

trait IsOrderable
{
    public function scopeOrdered($builder, $direction = 'asc')
    {
        $builder->orderBy('order', $direction);
    }
}
