<?php

namespace App\Http\Controllers\API;

use App\Adapters\ApiAdapter;
use App\DTOs\CreateCategoryDTO;
use App\DTOs\SearchCategoriesDTO;
use App\DTOs\UpdateCategoryDTO;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUpdateCategoryFormRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoriesService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CategoriesController extends Controller
{
    public function __construct(
        protected CategoriesService $categoriesService
    ) {}

    public function index(Request $request)
    {
        Log::info("CategoriesController::index => BEGIN");

        $categories = $this->categoriesService->findAll(SearchCategoriesDTO::makeFromRequest($request));

        Log::info("CategoriesController::index => END");

        return ApiAdapter::toJson($categories);
    }

    /**
     * @throws BadRequestException
     */
    public function store(CreateUpdateCategoryFormRequest $request)
    {
        Log::info("CategoriesController::store => BEGIN");

        $request->merge([ 'user_id' => $request->user()->id ?? '052402bf-4d5a-49c9-bfbc-2e29b14252df' ]);

        $category = $this->categoriesService->create(CreateCategoryDTO::makeFromRequest($request));

        Log::info("CategoriesController::store => END");

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     * @throws NotFoundException
     */
    public function show(string $id)
    {
        Log::info("CategoriesController::show => BEGIN");

        $category = $this->categoriesService->findById($id);

        Log::info("CategoriesController::show => END");

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     * @throws NotFoundException
     */
    public function update(CreateUpdateCategoryFormRequest $request, string $id)
    {
        Log::info("CategoriesController::update => BEGIN");

        $request->merge([ 'id' => $id, 'user_id' => $request->user()->id ?? '052402bf-4d5a-49c9-bfbc-2e29b14252df' ]);

        $category = $this->categoriesService->update(UpdateCategoryDTO::makeFromRequest($request));

        Log::info("CategoriesController::update => END");

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @throws NotFoundException
     */
    public function destroy(string $id)
    {
        Log::info("CategoriesController::destroy => BEGIN");

        $this->categoriesService->delete($id);

        Log::info("CategoriesController::destroy => END");

        return response()->json(null, 204);
    }
}
