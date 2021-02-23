<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewPromocode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Promocode\PromocodeStoreRequest;
use App\Http\Requests\Admin\Promocode\PromocodeUpdateRequest;
use App\Http\Resources\Promocode\PromocodeResource;
use App\Models\Promocode;
use Illuminate\Http\Request;

class PromocodeController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return PromocodeResource::collection(Promocode::query()->paginate());
    }

    /**
     * @param \App\Http\Requests\Admin\Promocode\PromocodeStoreRequest $request
     * @return \App\Http\Resources\Promocode\PromocodeResource
     */
    public function store(PromocodeStoreRequest $request)
    {
        $promocode = Promocode::create($request->validated());

        event(new NewPromocode($promocode));

        return new PromocodeResource($promocode);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Promocode $promocode
     * @return \App\Http\Resources\Promocode\PromocodeResource
     */
    public function show(Request $request, Promocode $promocode)
    {
        return new PromocodeResource($promocode);
    }

    /**
     * @param \App\Http\Requests\Admin\Promocode\PromocodeUpdateRequest $request
     * @param \App\Models\Promocode $promocode
     * @return \App\Http\Resources\Promocode\PromocodeResource
     */
    public function update(PromocodeUpdateRequest $request, Promocode $promocode)
    {
        $promocode->update($request->validated());

        return new PromocodeResource($promocode);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Promocode $promocode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Promocode $promocode)
    {
        $promocode->delete();

        return response()->noContent();
    }
}
