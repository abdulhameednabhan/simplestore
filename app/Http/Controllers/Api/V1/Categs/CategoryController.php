<?php
namespace App\Http\Controllers\Api\V1\Categs;
use App\Models\Category;
use App\Http\Requests\CategoryRequest\CategoryUpdateRequest;
use App\Http\Requests\CategoryRequest\CategoryStoreRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function __construct( )
    {
      
    }

    public function index()
    {
        $categories = Category::paginate(10);
        return response()->json($categories);
    }
    
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }



    public function store(CategoryStoreRequest $request)
    {
        $validatedData = $request->validated();
        $category = CategoryService::storeCategoryWithImage($validatedData['name'], $request->file('image'));

        return response()->json($category, 201);
    }

    public function update(CategoryUpdateRequest $request, $id)
    {
        $validatedData = $request->validated();
        $category = Category::findOrFail($id);
        $category = CategoryService::updateCategoryWithImage($category, $validatedData['name'], $request->file('image'));

        return response()->json($category);
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        CategoryService::deleteCategoryWithImage($category);

        return response()->json(['success' => 'deleted'], 204);
    }
}
