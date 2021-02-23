<?php

namespace App\Http\Controllers;

use App\Http\Requests\FcmTokenStoreRequest;
use App\Http\Resources\FcmTokenResource;
use App\Models\FcmToken;
use Illuminate\Http\Request;

class FcmTokenController extends Controller
{


    /**
     * @param \App\Http\Requests\FcmTokenStoreRequest $request
     * @return \App\Http\Resources\FcmTokenResource
     */
    public function store(FcmTokenStoreRequest $request)
    {
        auth()->user()->tokens()->firstOrCreate(['token' => $request->token, 'device' => 'web']);
        $fcmToken = FcmToken::create($request->validated());

        return new FcmTokenResource($fcmToken);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FcmToken $fcmToken
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FcmToken $fcmToken)
    {
        $fcmToken->delete();

        return response()->noContent();
    }

}
