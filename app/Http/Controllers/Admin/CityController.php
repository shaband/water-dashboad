<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\City\{CityStoreRequest, CityUpdateRequest};
use App\Http\Resources\City\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {

        return CityResource::collection(City::paginate());
    }

    /**
     * @param CityStoreRequest $request
     * @return CityResource
     */
    public function store(CityStoreRequest $request)
    {
        $city = City::create($request->validated());

        return new CityResource($city);
    }


    /**
     * @param Request $request
     * @param City $city
     * @return CityResource
     */
    public function show(Request $request, City $city)
    {
        return new CityResource($city);
    }


    /**
     * @param CityUpdateRequest $request
     * @param City $city
     * @return CityResource
     */
    public function update(CityUpdateRequest $request, City $city)
    {
        $city->update($request->validated());

        return new CityResource($city);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, City $city)
    {
        $city->delete();

        return response()->noContent();
    }
}
