<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Provider\ProviderStoreRequest;
use App\Http\Requests\Admin\Provider\ProviderUpdateRequest;
use App\Http\Resources\Provider\ProviderResource;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {

        return ProviderResource::collection(Provider::paginate());
    }

    /**
     * @param ProviderStoreRequest $request
     * @return ProviderResource
     */
    public function store(ProviderStoreRequest $request)
    {
        $provider = Provider::create($request->validated());

        return new ProviderResource($provider);
    }

    /**
     * @param Request $request
     * @param Provider $provider
     * @return ProviderResource
     */
    public function show(Request $request, Provider $provider)
    {
        return new ProviderResource($provider);
    }

    /**
     * @param ProviderUpdateRequest $request
     * @param Provider $provider
     * @return ProviderResource
     */
    public function update(ProviderUpdateRequest $request, Provider $provider)
    {
        $provider->update($request->validated());

        return new ProviderResource($provider);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Provider $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Provider $provider)
    {
        $provider->delete();

        return response()->noContent();
    }
}
