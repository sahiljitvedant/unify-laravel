<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppInfoController extends Controller
{
    public function appInfo()
    {
        $data = [
            'name' => 'Gym Management',
            'env'  => app()->environment(),
        ];

        return response()->json($data, 200)
            ->header('X-System', 'Gym')
            ->header('X-Powered-By', 'Sahils Laravel');
    }
}
