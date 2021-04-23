<?php

namespace App\Http\Controllers;

use App\ProductImg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function ajax_upload_img()
    {
        // A list of permitted file extensions
        $allowed = array('png', 'jpg', 'gif','zip');
        if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            if(!in_array(strtolower($extension), $allowed)){
                echo '{"status":"error"}';
                exit;
            }
            $name = strval(time().md5(rand(100, 200)));
            $ext = explode('.', $_FILES['file']['name']);
            $filename = $name . '.' . $ext[1];
            //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
            if( ! is_dir('upload/')){
                mkdir('upload/');
            }
            //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
            if ( ! is_dir('upload/img')) {
                mkdir('upload/img');
            }
            $destination = public_path().'/upload/img/'. $filename; //change this directory
            $location = $_FILES["file"]["tmp_name"];
            move_uploaded_file($location, $destination);
            echo "/upload/img/".$filename;//change this URL
        }
        exit;
    }

    public function ajax_delete_img(Request $request){
        if(file_exists(public_path().$request->file_link)){
            File::delete(public_path().$request->file_link);
        }
    }

    public function ajax_delete_product_imgs(Request $request)
    {
        $product_imgs_id = $request->product_imgs_id;

        //多張圖片組的單一圖片刪除
        $product_img = ProductImg::where('id',$product_imgs_id)->first();
        $old_product_img = $product_img->img;
        if(file_exists(public_path().$old_product_img)){
            File::delete(public_path().$old_product_img);
        }
        $product_img->delete();
        echo '{"status":"success","message":"delete file success"}';
    }

    public function ajax_sort_product_imgs(Request $request)
    {
        $product_imgs_id = $request->product_imgs_id;
        $sort_value = $request->sort_value;

        $ProductImg = ProductImg::find($product_imgs_id);
        $ProductImg->sort = $sort_value;
        $ProductImg->save();
        echo '{"status":"success","message":"sort img success"}';
    }
}
