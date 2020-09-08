<?php

namespace App\Helpers;

class ApiResponse {

    /**
     * Returns a json-encoded response with a success status of 200. Merges in an optional array of indexed $data
     *
     * @param   array $data
     * @return  string
     */
    public static function success($data = [])
    {
        return self::response(200, $data);
    }

    /**
     * Returns a json-encoded response with an error status of 400. Merges in an optional array of indexed $data
     *
     * @param   array $data
     * @return  string
     */
    public static function error($data = [])
    {
        return self::response(400, $data);
    }

    /**
     * Merges together an integer $status and an array of indexed $data and constructs a json response
     *
     * @param   integer   $status
     * @param   array     $data
     *
     * @return  string
     */
    private static function response($status, $data)
    {
        $response = ['status' => $status];

        foreach ($data as $key => $datum) {
            $response[$key] = $datum;
        }

        return json_encode($response);
    }

}
