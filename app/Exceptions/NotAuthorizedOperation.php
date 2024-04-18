<?php


namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class NotAuthorizedOperation extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['error' => 'Operação não autorizada.'], 400);
    }
}
