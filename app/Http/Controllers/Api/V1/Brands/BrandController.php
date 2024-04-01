<?php

namespace App\Http\Controllers;

use App\Models\Brand;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::paginate(10);
        return response()->json($brands);
    }

    
    public function store(Request $request)
    {
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->save();

        return response()->json($brand, 201);
    }

   
    public function show($id)
    {
        $brand = Brand::findOrFail($id);
        return response()->json($brand);
    }

  
    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->save();

        return response()->json($brand);
    }

   
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return response()->json(null, 204);
    }
    //
}
