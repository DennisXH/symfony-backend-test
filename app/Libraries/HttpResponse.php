<?php
namespace App\Libraries;

class HttpResponse
{
    public const STATUS = [
        'success'      => 200,
        'bad_request'  => 400,
        'unauthorized' => 401,
        'not_found'    => 404
    ];

    public static function json(string $httpStatus, $response)
    {
        if (array_key_exists($httpStatus, self::STATUS) == false) {
            $httpStatus = 'success';
        }

        http_response_code(self::STATUS[$httpStatus] ?? self::STATUS['success']);
        echo json_encode([$response]);
        exit;
    }
}