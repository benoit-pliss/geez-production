<?php

namespace App\Http\Controllers\Tags;

use App\Http\Controllers\Controller;
use App\Models\Tags;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public static function getTags(Request $request)
    {
        return response()->json([
            'success' => true,
            'tags' => Tags::all(),
        ]);
    }

    public static function getParentTags(Request $request)
    {
        return response()->json([
            'success' => true,
            'tags' => Tags::where('ParentTag', null)->get(),
        ]);
    }

    public static function getChildTags(Request $request)
    {
        return response()->json([
            'success' => true,
            'tags' => Tags::where('ParentTag', '!=', null)->get(),
        ]);
    }


}
