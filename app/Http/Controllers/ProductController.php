<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate();
        return ProductResource::collection($products);
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return ProductResource::make($product);
    }
    public function store(Request $request)
    {

    }
    public function update(Request $request, $id)
    {

    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
