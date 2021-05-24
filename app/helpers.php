<?php

if(!function_exists('reference_generator'))
{
    function reference_generator(string $value, int $length) : string
    {
        $code = '';

        for($i = 0; $i < $length; $i++){
            $code .= mt_rand(0,9);
        }

        return $value.$code;
    }
}
