<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    Public Function index()
    {
        $product = product ::all();

        dd($products);
    }
}
