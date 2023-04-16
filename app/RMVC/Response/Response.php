<?php

namespace App\RMVC\Response;

class Response
{
    /**
     * @param array $data
     * 
     * @return string
     */
    public static function json(array $data): string
    {
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($data);
    }
}