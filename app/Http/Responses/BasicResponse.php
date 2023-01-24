<?php

namespace App\Http\Responses;

use Throwable;

class BasicResponse
{
    public const SUCCESS_STATUS = 'Success';
    public const SUCCESS_CODE = 200;
    public const SUCCESS_MESSAGE = 'Success!';

    public const ERROR_STATUS = 'Error';
    public const ERROR_CODE = 500;
    public const ERROR_MESSAGE = 'Error!';

    private static function makeResponse(string $status, string $message, int $code): array
    {
        return [
            "status" => $status,
            "code" => $code,
            "message" => $message,
        ];
    }

    public static function makeSuccess(string $message = self::SUCCESS_MESSAGE, int $code = self::SUCCESS_CODE, string $status = self::SUCCESS_STATUS): array
    {
        return self::makeResponse($status, $message, $code);
    }

    public static function makeError(string $message = self::ERROR_MESSAGE, int $code = self::ERROR_CODE, string $status = self::ERROR_STATUS): array
    {
        return self::makeResponse($status, $message, $code);
    }

    public static function parseThrowableToError(Throwable $e): array
    {
        return self::makeError($e->getMessage(), $e->getCode());
    }
}