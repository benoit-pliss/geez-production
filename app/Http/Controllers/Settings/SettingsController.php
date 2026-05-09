<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Files;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(): JsonResponse
    {
        $settings = Setting::all()->pluck('value', 'key');

        $featuredVideo = null;
        if (!empty($settings['featured_video_id'])) {
            $featuredVideo = Files::with('tags')->find((int) $settings['featured_video_id']);
        }

        return response()->json([
            'success'        => true,
            'settings'       => $settings,
            'featured_video' => $featuredVideo,
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'featured_video_id'  => 'nullable|integer',
            'video_default_sound' => 'nullable|boolean',
        ]);

        foreach ($request->only(['featured_video_id', 'video_default_sound']) as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value !== null ? (is_bool($value) ? ($value ? '1' : '0') : (string) $value) : null]
            );
        }

        return response()->json(['success' => true]);
    }
}
