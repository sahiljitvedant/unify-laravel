<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ThemeController extends Controller
{
    /* =======================
     * THEME SETTINGS PAGE
     * ======================= */
    public function index()
    {
        $theme = DB::table('tbl_theme_settings')->first();

        return view('theme.index', compact('theme'));
    }

    /* =======================
     * UPDATE THEME
     * ======================= */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'theme_color'      => 'required|string',
            'sidebar_color'    => 'required|string',
            'sidebar_light'    => 'required|string',
            'font_size'        => 'required|string',
            'font_size_10px'   => 'required|string',
            'black_color'      => 'required|string',
            'other_color_fff'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }

        try {
            DB::table('tbl_theme_settings')->updateOrInsert(
                ['id' => 1],
                [
                    'theme_color'     => $request->theme_color,
                    'sidebar_color'   => $request->sidebar_color,
                    'sidebar_light'   => $request->sidebar_light,
                    'font_size'       => $request->font_size,
                    'font_size_10px'  => $request->font_size_10px,
                    'black_color'     => $request->black_color,
                    'other_color_fff' => $request->other_color_fff,
                    'updated_at'      => now(),
                ]
            );

            return response()->json([
                'status'  => 'success',
                'message' => 'Theme updated successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Theme Update Error: '.$e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }
}
