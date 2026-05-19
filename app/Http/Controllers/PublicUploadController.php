<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicUploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('', ['disk' => 'uploads']);
            return response()->json(['path' => $path], 200);
        }
        return response()->json('File not provided', 422);
    }
}
