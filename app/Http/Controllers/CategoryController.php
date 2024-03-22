<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Http\Requests\CategoryRequest\CategoryUpdateRequest;
use App\Http\Requests\CategoryRequest\CategoryStoreRequest;
use App\Customs\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
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
        $category = $this->categoryService->storeCategoryWithImage($validatedData['name'], $request->file('image'));

        return response()->json($category, 201);
    }

    public function update(CategoryUpdateRequest $request, $id)
    {
        $validatedData = $request->validated();
        $category = Category::findOrFail($id);
        $category = $this->categoryService->updateCategoryWithImage($category, $validatedData['name'], $request->file('image'));

        return response()->json($category);
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $this->categoryService->deleteCategoryWithImage($category);

        return response()->json(['success' => 'deleted'], 204);
    }
}
