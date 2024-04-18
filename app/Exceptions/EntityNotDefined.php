<?php


namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class EntityNotDefined extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['error' => 'Entidade não definida.'], 500);
    }
}
