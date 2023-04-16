<?php

namespace App\Http\Controllers;

class Controller
{
    /**
     * @var array
     */
    protected array $data = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->data = $this->xss($_REQUEST);
    }

    /**
     * @param $data
     * @return array|string
     */
    private function xss($data): array|string
    {
        if (is_array($data))
        {
            $result = [];
            foreach ($data as $key => $value)
            {
                $result[$key] = $this->xss($value);
            }
            return $result;
        }
        return htmlspecialchars($data, ENT_QUOTES);
    }
}