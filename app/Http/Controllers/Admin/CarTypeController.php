<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CarType\{CarTypeStoreRequest, CarTypeUpdateRequest};
use App\Http\Resources\CarType\CarTypeResource;
use App\Models\CarType;
use Illuminate\Http\Request;

class CarTypeController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return CarTypeResource::collection(CarType::paginate());
    }

    /**
     * @param CarTypeStoreRequest $request
     * @return CarTypeResource
     */
    public function store(CarTypeStoreRequest $request)
    {
        $carType = CarType::create($request->validated());

        return new CarTypeResource($carType);
    }


    /**
     * @param Request $request
     * @param CarType $carType
     * @return CarTypeResource
     */
    public function show(Request $request, CarType $carType)
    {
        return new CarTypeResource($carType);
    }


    /**
     * @param CarTypeUpdateRequest $request
     * @param CarType $carType
     * @return CarTypeResource
     */
    public function update(CarTypeUpdateRequest $request, CarType $carType)
    {
        $carType->update($request->validated());

        return new CarTypeResource($carType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CarType $carType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CarType $carType)
    {
        $carType->delete();

        return response()->noContent();
    }
}
