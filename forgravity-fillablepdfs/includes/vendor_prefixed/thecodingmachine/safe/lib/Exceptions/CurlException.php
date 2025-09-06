<?php

namespace ForGravity\Fillable_PDFs\Safe\Exceptions;

class CurlException extends \Exception implements SafeExceptionInterface
{
    /**
     * @param resource $ch
     */
    public static function createFromCurlResource($ch) : self
    {
        return new self(\curl_error($ch), \curl_errno($ch));
    }
}
