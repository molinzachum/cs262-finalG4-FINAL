<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'upload' => [
                'required',
                'image',
                'max:2048'
            ]
        ]);

        $path = $request->file('upload')
            ->store('ckeditor', 'public');

        return response()->json([
            'url' => asset('storage/' . $path)
        ]);
    }
}