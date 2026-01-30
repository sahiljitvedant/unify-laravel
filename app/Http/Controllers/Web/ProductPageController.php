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
        $product = AboutPage::with('header')
        ->where('slug', $slug)
        ->where('status', 1)
        ->firstOrFail();
        

        // dd($product);
        
        return view('front.product_page', compact('product'));
      
    }
}
