<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryItem;
use App\Http\Requests\CreateCategoryRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request) {
        $limit = $request->query('per_page') ?? 20;
        $sort = $request->query('sort') ?? 'id';
        $order = $request->query('order') ?? 'desc';
        $searchTerm = $request->query('q') ?? null;
        $categoryItems = CategoryItem::select('category_items.id', 'category_items.category_id', 'c.name as category_name', 'category_items.name', 'category_items.image', 'category_items.description', DB::raw('concat("₹", category_items.price) as price'), 'category_items.quantity')
            ->leftJoin('categories as c', 'category_items.category_id', '=', 'c.id')
            ->when($searchTerm, function($query) use($searchTerm) {
                $query->where('category_items.name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('category_items.description', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('category_items.price', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('c.name', 'LIKE', '%' . $searchTerm . '%');
            })
            ->orderBy($sort, $order)->get();
        if (!auth()->user()->is_admin) return view('userHome', ['products' => $categoryItems]);
        return view('adminHome', ['products' => $categoryItems]);
    }

    public function show($id) {
        $categoryItem = CategoryItem::with('category:id,name,image')
        ->select('id', 'category_id', 'name', 'image', 'description', 'price', 'quantity')
        ->find($id);
        $categories = $this->categories();
        return view('productEdit', ['categories' => $categories, 'product' => $categoryItem]);
    }

    public function getItem(Request $req) {
        $id = $req->query('id');
        $categoryItem = CategoryItem::with('category:id,name,image')
        ->select('id', 'category_id', 'name', 'image', 'description', 'price', 'quantity')
        ->find($id);
        return $categoryItem;
    }

    public function categoryForm() {
        $categories = $this->categories();
        $product = (object) [
            'id' => '',
            'category_id' => '',
            'name' => '',
            'image' => '',
            'description' => '',
            'price' => '',
            'quantity' => '',
            'category' => [
                'id' => '',
                'name' => '',
                'image' => ''
            ]
        ];
        return view('productCreate', ['categories' => $categories, 'product' => $product]);
    }

    public function categories() {
        return Category::select('id', 'name', 'image')->get();
    }

    public function store(CreateCategoryRequest $request) {
        $category = new Category();
        $categoryName = $request->new_category_name ?? $request->category_name;
        $category = $category->firstWhere('name', $categoryName);
        if ($request->hasFile('item_image')) {
            $itemImage = $request->file('item_image');
            $itemImageName = time() . '_' . $itemImage->getClientOriginalName();
            $this->storeImage('item', $itemImage, $itemImageName);
        }
        $data = $request->all();
        $userId = auth()->user()->id;
        if (!$category) {
            $category = Category::create([
                'name' => $categoryName,
                'created_by' => $userId,
                'updated_by' => $userId
            ]);
        }
        $category->categoryItems()->create([
            'name' => $data['item_name'],
            'image' => $itemImageName ?? null,
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'created_by' => $userId,
            'updated_by' => $userId
        ]);
        return redirect(route('home'))->with('success', 'Product added successfully');
    }

    public function update($id, CreateCategoryRequest $request) {
        $categoryName = $request->new_category_name ?? $request->category_name;
        $category = Category::firstWhere('name', $categoryName);
        $data = $request->all();
        $userId = auth()->user()->id;
        if (!$category) {
            $category = Category::create([
                'name' => $categoryName,
                'created_by' => $userId,
                'updated_by' => $userId
            ]);
        }
        $categoryItem = CategoryItem::findOrFail($id);
        if ($request->hasFile('item_image')) {
            $itemImage = $request->file('item_image');
            if ($categoryItem->image != $itemImage->getClientOriginalName()) {
                $itemImageName = time() . '_' . $itemImage->getClientOriginalName();
                $this->storeImage('item', $itemImage, $itemImageName);
                unlink(public_path('images/item/'.$categoryItem->image));
            }
        }
        $categoryItem->update([
            'name' => $data['item_name'],
            'image' => $itemImageName ?? $categoryItem->image,
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'updated_by' => $userId
        ]);
        $category->categoryItems()->save($categoryItem);
        return redirect(route('home'))->with('success', 'Product updated successfully');
    }

    public function storeImage($path, $file, $fileName) {
        Storage::putFileAs($path, $file, $fileName);
    }

    public function deleteCategory($id) {
        $category = Category::findOrFail($id);
        $category->categoryItems()->delete();
        $category->delete();
        return response()->json([
            'message' => 'Category deleted successfully'
        ], 200);
    }

    public function deleteCategoryItem($id) {
        CategoryItem::findOrFail($id)->delete();
        return back()->with('success', 'Product deleted successfully');
    }
}
