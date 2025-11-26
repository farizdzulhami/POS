<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        return view('home');
    }
    public function contact() {
        return view('contact');
    }
    public function about() {
        return view('about');
    }

    public function testing() {
        $category = Category::get();
        $product = Product::with('category')->get();    
        dd($category);
    }
}