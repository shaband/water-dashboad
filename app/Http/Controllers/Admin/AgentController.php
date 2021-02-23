<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Agent\{AgentStoreRequest, AgentUpdateRequest};
use App\Http\Resources\Agent\AgentResource;
use App\Http\Resources\Mark\MarkResource;
use App\Models\Agent;
use App\Models\Mark;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        return AgentResource::collection(Agent::paginate());
    }

    /**
     * @param AgentStoreRequest $request
     * @return AgentResource
     */
    public function store(AgentStoreRequest $request)
    {
        $agent = Agent::create($request->validated());
        $agent->cities()->sync(array_column($request->cities,'id') ?? []);
        return new AgentResource($agent);
    }

    /**
     * @param Request $request
     * @param Agent $agent
     * @return AgentResource
     */
    public function show(Request $request, Agent $agent)
    {
        return new AgentResource($agent->load('cities'));
    }

    /**
     * @param AgentUpdateRequest $request
     * @param Agent $agent
     * @return AgentResource
     */
    public function update(AgentUpdateRequest $request, Agent $agent)
    {
        $agent->update($request->validated());
        $agent->cities()->sync(array_column($request->cities,'id') ?? []);
        return new AgentResource($agent);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Agent $agent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Agent $agent)
    {
        $agent->delete();

        return response()->noContent();
    }

    /**
     * @param Request $request
     * @param Agent $agent
     * @return AgentResource
     */
    public function block(Request $request, Agent $agent)
    {
        $agent->toggleBlock();
        return new AgentResource($agent);
    }

}
