<?php

namespace App\Http\Controllers\API;

use App\Adapters\ApiAdapter;
use App\DTOs\CreateTaskDTO;
use App\DTOs\SearchTasksDTO;
use App\DTOs\UpdateTaskDTO;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUpdateTaskFormRequest;
use App\Http\Resources\TaskResource;
use App\Services\TasksService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TasksController extends Controller
{
    public function __construct(
        protected TasksService $tasksService
    ) {}

    public function index(Request $request)
    {
        Log::info("TasksController::index => BEGIN");

        $tasks = $this->tasksService->findAll(SearchTasksDTO::makeFromRequest($request));

        Log::info("TasksController::index => END");

        return ApiAdapter::toJson($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUpdateTaskFormRequest $request)
    {
        Log::info("TasksController::store => BEGIN");

        $request->merge([ 'user_id' => $request->user()->id ]);

        $task = $this->tasksService->create(CreateTaskDTO::makeFromRequest($request));

        Log::info("TasksController::store => END");

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     * @throws NotFoundException
     */
    public function show(string $id)
    {
        Log::info("TasksController::show => BEGIN");

        $task = $this->tasksService->findById($id);

        Log::info("TasksController::show => END");

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     * @throws NotFoundException
     */
    public function update(CreateUpdateTaskFormRequest $request, string $id)
    {
        Log::info("TasksController::update => BEGIN");

        $request->merge([ 'id' => $id, 'user_id' => $request->user()->id ]);

        $category = $this->tasksService->update(UpdateTaskDTO::makeFromRequest($request));

        Log::info("TasksController::update => END");

        return (new TaskResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @throws NotFoundException
     */
    public function destroy(string $id)
    {
        Log::info("TasksController::destroy => BEGIN");

        $this->tasksService->delete($id);

        Log::info("TasksController::destroy => END");

        return response()->json(null, 204);
    }
}
