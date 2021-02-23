<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Mark\{MarkStoreRequest, MarkUpdateRequest};

use App\Http\Resources\Mark\MarkResource;
use App\Models\Mark;
use Illuminate\Http\Request;

class MarkController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return MarkResource::collection(Mark::paginate());
    }


    /**
     * @param MarkStoreRequest $request
     * @return MarkResource
     */
    public function store(MarkStoreRequest $request)
    {
        $mark = Mark::create($request->validated());

        return new MarkResource($mark);
    }


    /**
     * @param Request $request
     * @param Mark $mark
     * @return MarkResource
     */
    public function show(Request $request, Mark $mark)
    {
        return new MarkResource($mark);
    }


    /**
     * @param MarkUpdateRequest $request
     * @param Mark $mark
     * @return MarkResource
     */
    public function update(MarkUpdateRequest $request, Mark $mark)
    {
        $mark->update($request->validated());

        return new MarkResource($mark);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Mark $mark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Mark $mark)
    {
        $mark->delete();

        return response()->noContent();
    }

    /**
     * @param Request $request
     * @param Mark $mark
     * @return MarkResource
     */
    public function block(Request $request, Mark $mark)
    {
        $mark->toggleBlock();
        return new MarkResource($mark);
    }
}
