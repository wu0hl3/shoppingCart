<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductType;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index()
    {
        $news = DB::table('news')->where('sort','<=','20')->get();
        $products = DB::table('products')->where('id','<=','3')->get();
        return view("front.index", compact('news','products'));
    }

    public function products()
    {
        $ProductTypes = ProductType::orderBy('sort', 'desc')->with('products')->get();
        foreach( $ProductTypes as $type){
            $type->products = $type->products->take(3);
        }

        return view("front.products", compact("ProductTypes"));
    }

    public function products_type($id)
    {
        $ProductTypes = ProductType::where('id',$id)->with('products')->get();

        return view("front.products", compact("ProductTypes"));
    }

    public function products_detail($id)
    {
        $product = Product::where('id',$id)->with('product_imgs')->first();
        return view("front.products_detail", compact("product"));
    }

    public function news()
    {
        $items = DB::table('news')->paginate(5);
        return view("front.news", compact("items"));
    }

    public function news_detail($id)
    {
        $item = DB::table('news')->find($id);
        return view("front.news_detail", compact("item"));
    }
}
