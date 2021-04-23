<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductImg;
use App\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $items =  Product::with('productType')->get();
        return view('admin.product.index',compact("items"));
    }

    public function create()
    {
        $productTypes = ProductType::all();
        return view('admin.product.create',compact('productTypes'));
    }

    public function store(Request $request)
    {
        $requsetData = $request->all();

        //單一檔案
        if($request->hasFile('img')) {
            $file = $request->file('img');
            $path = $this->fileUpload($file,'product');
            $requsetData['img'] = $path;
        }

        $new_product =  Product::create($requsetData);
        $new_product_id = $new_product->id;

        //多個檔案
        if($request->hasFile('imgs'))
        {
            $files = $request->file('imgs');
            foreach ($files as $file) {
                //上傳圖片
                $path = $this->fileUpload($file,'product_imgs');
                //新增資料進DB
                $product_img = new ProductImg;
                $product_img->product_id = $new_product_id;
                $product_img->img = $path;
                $product_img->save();
            }
        }

        return redirect('/admin/product');
    }

    public function edit($id)
    {
        $productTypes = ProductType::all();
        $item = Product::where('id',$id)->with('product_imgs')->first();
        return view('admin.product.edit',compact('item','productTypes'));
    }

    public function update(Request $request, $id)
    {
        $item = Product::find($id);

        $requsetData = $request->all();
        if($request->hasFile('img')) {      //如果使用者有重新上傳圖片
            $old_image = $item->img;        //抓取舊圖片路徑
            File::delete(public_path().$old_image); //把舊圖片刪除

            //上傳圖片
            $file = $request->file('img');
            $path = $this->fileUpload($file,'product');
            $requsetData['img'] = $path;
        }


        //多個檔案
        if($request->hasFile('imgs'))
        {
            $files = $request->file('imgs');
            foreach ($files as $file) {
                //上傳圖片
                $path = $this->fileUpload($file,'product_imgs');
                //新增資料進DB
                $product_img = new ProductImg;
                $product_img->product_id = $id;
                $product_img->img = $path;
                $product_img->save();
            }
        }

        $item->update($requsetData);

        return redirect('/admin/product');
    }

    public function destroy($id)
    {
        $item = Product::find($id);

        //單一圖片的刪除
        $old_image = $item->img;
        if(file_exists(public_path().$old_image)){
            File::delete(public_path().$old_image);
        }
        $item->delete();

        //多張圖片的刪除
        $product_imgs = ProductImg::where('product_id',$id)->get();
        foreach($product_imgs as $product_img){
            $old_product_img = $product_img->img;
            if(file_exists(public_path().$old_product_img)){
                File::delete(public_path().$old_product_img);
            }

            $product_img->delete();
        }



        return redirect('/admin/product');
    }

    private function fileUpload($file,$dir){
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if( ! is_dir('upload/')){
            mkdir('upload/');
        }
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if ( ! is_dir('upload/'.$dir)) {
            mkdir('upload/'.$dir);
        }
        //取得檔案的副檔名
        $extension = $file->getClientOriginalExtension();
        //檔案名稱會被重新命名
        $filename = strval(time().md5(rand(100, 200))).'.'.$extension;
        //移動到指定路徑
        move_uploaded_file($file, public_path().'/upload/'.$dir.'/'.$filename);
        //回傳 資料庫儲存用的路徑格式
        return '/upload/'.$dir.'/'.$filename;
    }
}
