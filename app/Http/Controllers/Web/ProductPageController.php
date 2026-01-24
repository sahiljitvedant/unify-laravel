<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutPage;
class ProductPageController extends Controller
{
    public function show($slug)
    {
        // dd(2);
        // dd($slug);
        $page = AboutPage::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        return view('front.product_page', compact('page'));
    }
}
