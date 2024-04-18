<?php

namespace App\Http\Controllers\API;

use App\Adapters\ApiAdapter;
use App\DTOs\CreateTaskDTO;
use App\DTOs\SearchTasksDTO;
use App\DTOs\UpdateTaskDTO;
use App\Exceptions\NotAuthorizedOperation;
use App\Exceptions\TaskNotFound;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Requests\CreateUpdateTaskFormRequest;
use App\Services\TasksService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TasksController extends Controller
{
    public function __construct(
        protected TasksService $tasksService
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        $tasks = $this->tasksService->findAll(SearchTasksDTO::makeFromRequest($request));

        return ApiAdapter::toJson($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUpdateTaskFormRequest $request
     */
    public function store(CreateUpdateTaskFormRequest $request)
    {
        $request->merge([ 'user_id' => $request->user()->id ]);

        $task = $this->tasksService->create(CreateTaskDTO::makeFromRequest($request));

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     */
    public function show(Request $request, int $id)
    {
        try {
            $task = $this->tasksService->findById($request->user()->id, $id);

            return new TaskResource($task);
        } catch (TaskNotFound|NotAuthorizedOperation $e) {
          return response($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateUpdateTaskFormRequest  $request
     * @param  int  $id
     */
    public function update(CreateUpdateTaskFormRequest $request, int $id)
    {
        try {
            $request->merge([ 'user_id' => $request->user()->id ]);

            $task = $this->tasksService->update(UpdateTaskDTO::makeFromRequest($request, $id));

            return new TaskResource($task);
        } catch (TaskNotFound|NotAuthorizedOperation $e) {
            return response($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @throws TaskNotFound
     */
    public function destroy(int $id)
    {
        $this->tasksService->delete($id);
    }
}
