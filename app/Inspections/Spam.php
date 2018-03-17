<?php

namespace App\Inspections;

class Spam
{
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class,
    ];

    public function detect($items)
    {
        $items = (array) $items;

        foreach ($items as $item) {
            foreach ($this->inspections as $inspection) {
                app($inspection)->detect($item);
            }
        }

        return false;
    }
}
