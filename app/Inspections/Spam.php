<?php

namespace App\Inspections;

class Spam
{
    /**
     * All registered inspections.
     *
     * @var array
     */
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class,
    ];

    /**
     * Detect spam.
     *
     * @param  string $body
     * @return bool
     */
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
