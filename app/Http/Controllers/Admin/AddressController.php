<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Address\{AddressStoreRequest, AddressUpdateRequest};
use App\Http\Resources\Address\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return AddressResource::collection(Address::paginate());
    }

    /**
     * @param \App\Http\Requests\Admin\Address\AddressStoreRequest $request
     * @return AddressResource
     */
    public function store(AddressStoreRequest $request)
    {
        $address = Address::create($request->validated());

        return new AddressResource($address);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Address $address
     * @return AddressResource
     */
    public function show(Request $request, Address $address)
    {
        return new AddressResource($address);
    }

    /**
     * @param \App\Http\Requests\Admin\Address\AddressUpdateRequest $request
     * @param \App\Models\Address $address
     * @return AddressResource
     */
    public function update(AddressUpdateRequest $request, Address $address)
    {
        $address->update($request->validated());

        return new AddressResource($address);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Address $address)
    {
        $address->delete();

        return response()->noContent();
    }
}
