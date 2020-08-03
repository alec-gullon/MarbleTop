<?php

namespace App\Helpers;

class ApiResponse {

    public static function success($data) {
        $response = ['status' => 200];

        foreach ($data as $key => $datum) {
            $response[$key] = $datum;
        }

        return json_encode($response);
    }

    public static function error($data) {
        $response = ['status' => 400];

        foreach ($data as $key => $datum) {
            $response[$key] = $datum;
        }

        return json_encode($response);
    }

}
