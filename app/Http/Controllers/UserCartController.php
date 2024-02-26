<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryItem;
use App\Models\UserCart;
use App\Models\User;
use App\Http\Requests\AddToCartRequest;

class UserCartController extends Controller
{
    public function index(Request $request) {
        $userId = auth()->user()->id;
        $userCart = User::with('cart.categoryItem')->find($userId);
        return view('userCart', ['cart' => $userCart->cart]);
    }

    public function store(AddToCartRequest $request) {
        $data = $request->all();
        $item = CategoryItem::find($data['product_id']);
        $item->update(['quantity' => $item->quantity - $data['quantity']]);
        $userCart = UserCart::create([
            'user_id' => auth()->user()->id,
            'category_item_id' => $item->id,
            'quantity' => $data['quantity']
        ]);
        return response()->json([
            'message' => 'Item added to cart successfully',
            'cart' => $userCart
        ], 201);
    }
}
