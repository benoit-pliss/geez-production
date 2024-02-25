<?php

namespace App\Http\Controllers\Tags;

use App\Http\Controllers\Controller;
use App\Models\Tags;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public static function getTagByName(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        return response()->json([
            'success' => true,
            'tag' => Tags::where('name', $request->name)->first(),
        ]);
    }

    public static function store(Request $request) : JsonResponse
    {

        $request->validate([
            'name' => 'required',
        ]);

        if (Tags::class::where('name', $request->name)->first()) {
            return response()->json([
                'success' => false,
                'message' => 'Tag already exists',
            ]);
        }


        return response()->json([
            'success' => true,
            'tag' => Tags::class::create($request->all()),
        ]);
    }


}
