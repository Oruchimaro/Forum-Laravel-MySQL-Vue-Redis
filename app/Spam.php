<?php

namespace App;

class Spam
{
    public function detect($body)
    {
        //detect invalid key words
        $this->detectInvalidKeywords($body);
        $this->detectKeyHeldDown($body);


        //if no exception is thrown then there is no spam,return false
        return false;
    }


    public function detectInvalidKeywords($body)
    {
        $invalidsKeywords = [
            'yahoo customer support',
            'pussy'
        ];

        foreach ($invalidsKeywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new \Exception('Your reply contains invalid keyword(s).its a spam!!!');
            }
        }
    }


    public function detectKeyHeldDown($body)
    {
        if (preg_match('/(.)\\1{4,}/', $body)) {
            throw new \Exception('Your reply contains held down key.its a  spam!!!');
        }
    }
}
