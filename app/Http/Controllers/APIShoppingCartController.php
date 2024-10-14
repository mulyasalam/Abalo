<?php

namespace App\Http\Controllers;

use App\Models\AbShoppingCart;
use App\Models\AbShoppingCartItem;
use App\Models\AbArticle;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class APIShoppingCartController extends Controller

{
    function init(Request $request)
    {
        // Get the shopping cart from the database
        $shoppingCart = AbShoppingCart::where('ab_creator_id', 1)->first();

        // If the shopping cart does not exist, create a new one
        if (!$shoppingCart) {
            $shoppingCart = AbShoppingCart::create([
                'ab_creator_id' => 1, //$request->session()->get('id'),
                'ab_createdate' => date('Y-m-d H:i:s')
            ]);
        }

        // Get the items in the shopping cart
        $items = AbShoppingCartItem::where('ab_shoppingcart_id', 1)->get();
        // $articles = Articles::where('', '1'])->get();
        $articles = [];

        foreach ($items as $item) {
            $article = AbArticle::where('id', $item->ab_article_id)->first();
            if ($article) {
                $articles[] = $article;
            }
        }

        return response()->json($articles);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'article_id' => 'required|numeric|min:0',
        ]);

        // Get the shopping cart from the session or create a new one if it doesn't exist
        $shoppingCart = AbShoppingCart::find(1);
        if (!$shoppingCart) {
            $shoppingCart = new Abshoppingcart();
            $shoppingCart->ab_creator_id = 1; // Set this to the actual user ID
            $shoppingCart->ab_createdate = date('Y-m-d H:i:s');
            $shoppingCart->save();
        }

        if( AbshoppingcartItem::where('ab_shoppingcart_id', $shoppingCart->id)->where('ab_article_id', $validatedData['article_id'])->exists()){
            return response()->json($shoppingCart);
        }
        // Add the item to the shopping cart
        $shoppingCartItem = new AbShoppingcartItem();
        $shoppingCartItem->ab_article_id = $validatedData['article_id'];
        $shoppingCartItem->ab_createdate = date('Y-m-d H:i:s');
        $shoppingCartItem->ab_shoppingcart_id = $shoppingCart->id;
        $shoppingCartItem->save();

        return response()->json($shoppingCart);
    }

    public function removeItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'article_id' => 'required|numeric|min:1',
            'shoppingcartid' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }

        // Get the shopping cart
        $shoppingCart = Abshoppingcart::find($request->shoppingcartid);

        // Check if the shopping cart exists
        if (!$shoppingCart) {
            return response()->json(['error' => 'Shopping cart not found'], 404);
        }

        // Remove the item from the shopping cart
        $deleted = AbShoppingcartItem::where('ab_shoppingcart_id', $request->shoppingcartid)
            ->where('ab_article_id', $request->article_id)
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Item removed successfully']);
        } else {
            return response()->json(['error' => 'Item not found in the cart'], 404);
        }
    }




}
