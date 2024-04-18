<?php


namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class IncorrectEmailOrPassword extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['error' => 'E-mail e/ou senha incorretos.'], 400);
    }
}
