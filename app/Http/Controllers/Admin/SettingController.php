<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\SettingUpdateRequest;
use App\Http\Resources\Setting\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        return SettingResource::collection(Setting::paginate());
    }

    /**
     * @param Request $request
     * @param Setting $setting
     * @return SettingResource
     */
    public function show(Request $request, Setting $setting)
    {
        return new SettingResource($setting);
    }

    /**
     * @param SettingUpdateRequest $request
     * @param Setting $setting
     * @return SettingResource
     */
    public function update(SettingUpdateRequest $request, Setting $setting)
    {
        $setting->update($request->validated());

        return new SettingResource($setting);
    }
}
