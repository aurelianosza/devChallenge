<?php

namespace App\Http\Helpers;

class Responser
{
    private $status;
    private $errors;
    private $data;

    public const OK             = 200;
    public const CREATED        = 201;
    public const ERROR          = 400;
    public const UNAUTHORIZED   = 401;
    public const NOT_FOUND      = 404;

    public function __construct(){
        $this->status = self::OK;
    }

    public function setData($data): void
    {
        $this->data = $data;
    }

    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function respond(){
        return response([
            'status'    => $this->status,
            'errors'    => $this->errors    ? $this->errors : [],
            'data'      => $this->data      ? $this->data   : []
        ], $this->status)
        ->header('Content-type'                 , 'text/json')
        ->header('Allow'                        , 'GET POST PUT DELETE')
        ->header('Access-Control-Allow-Origin'  , '*');
    }


}