<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest\ProductStoreRequest;
use App\Http\Requests\ProductRequest\ProductUpdateRequest;
use App\Customs\Services\ProductService; 
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = Product::paginate(10);
        if ($products) {
            return response()->json($products, 200);
        } else {
            return response()->json('no products');
        }
    }

    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json($product, 200);
        } else {
            return response()->json('product was not found');
        }
    }

    public function store(ProductStoreRequest $request)
    {
        $this->productService->storeProduct($request->validated(), $request->file('image'));
        return response()->json('Product added', 201);
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $this->productService->updateProduct($id, $request->validated(), $request->file('image'));
        return response()->json('Product updated', 200);
    }

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return response()->json('Product deleted', 200);
    }
}
