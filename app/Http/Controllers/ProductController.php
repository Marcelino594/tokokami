<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    Public Function index()
    {
        $products = product ::paginate(9);

        return view('products.index', compact('products'));
    }
}
