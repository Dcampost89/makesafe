<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function success($data, $message, $code) {
        return response()->json(['message' => $message, 'data' => $data],  $code);
    }

    public function error($message, $errors, $code) {
        return response()->json(['message' => $message, 'errors' => $errors], $code);
    }
}
