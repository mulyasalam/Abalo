<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbShoppingCartItem extends Model
{
    protected $table = 'ab_shoppingcart_item';
    public $timestamps = false;
    protected $fillable = ['ab_shoppingcart_id', 'ab_article_id','ab_createdate'];
    protected $primaryKey = 'id';

//    public static function search($id_s,$id_a)
//    {
//        return ShoppingcartItem::where('ab_shoppingcart_id', $id_s)->where('ab_article_id', $id_a)->first();
//
//    }
//
//    public static function getItems($id_s)
//    {
//        return ShoppingcartItem::where('ab_shoppingcart_id', $id_s)->join('ab_article', 'ab_article.id', '=','ab_shoppingcart_item.ab_article_id')->get();
//
//    }
}
