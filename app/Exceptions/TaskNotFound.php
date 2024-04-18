<?php


namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class TaskNotFound extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['error' => 'Tarefa não encontrada.'], 404);
    }
}
