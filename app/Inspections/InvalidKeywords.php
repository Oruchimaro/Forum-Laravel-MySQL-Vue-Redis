<?php

namespace App\Inspections;

class InvalidKeywords
{
    protected $keywords = [
        'yahoo customer support',
        'pussy',
        'fuck',
        'Iran'

    ];


    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new \Exception('Your reply contains invalid keyword(s).its a spam!!!');
            }
        }
    }
}
