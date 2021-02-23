<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mark\MarkResource;
use App\Models\Mark;
use App\Http\Requests\Admin\Delivery\{DeliveryStoreRequest, DeliveryUpdateRequest};
use App\Http\Resources\Delivery\DeliveryResource;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return DeliveryResource::collection(Delivery::paginate());
    }


    /**
     * @param DeliveryStoreRequest $request
     * @return DeliveryResource
     */
    public function store(DeliveryStoreRequest $request)
    {
        $delivery = Delivery::create($request->validated());

        return new DeliveryResource($delivery);
    }


    /**
     * @param Request $request
     * @param Delivery $delivery
     * @return DeliveryResource
     */
    public function show(Request $request, Delivery $delivery)
    {
        return new DeliveryResource($delivery);
    }


    /**
     * @param DeliveryUpdateRequest $request
     * @param Delivery $delivery
     * @return DeliveryResource
     */
    public function update(DeliveryUpdateRequest $request, Delivery $delivery)
    {
        $delivery->update($request->validated());

        return new DeliveryResource($delivery);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Delivery $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Delivery $delivery)
    {
        $delivery->delete();

        return response()->noContent();
    }



    /**
     * @param Request $request
     * @param Delivery $delivery
     * @return DeliveryResource
     */
    public function block(Request $request, Delivery $delivery)
    {
        $delivery->toggleBlock();
        return new DeliveryResource($delivery);
    }
}
