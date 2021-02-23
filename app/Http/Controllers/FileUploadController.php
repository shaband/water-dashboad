<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function create(Request $request)
    {

        $request->validate(['file' => ['required', 'image']]);
        $file = $request->file('file');
        $path = $file->storeAs('uploads', time() . '-' . $file->getClientOriginalName());

        return response()->json(['file' => $path]);
    }

    public function destroy(Request $request)
    {
        $request->validate(['file' => ['required', 'string']]);
        $path = $request->input('file');
        Storage::delete($path);
        return response()->noContent();
    }
}
