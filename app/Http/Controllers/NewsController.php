<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{

    public function index()
    {
        $items =  News::all();
        return view('admin.news.index',compact("items"));
    }


    public function create()
    {
        return view('admin.news.create');
    }


    public function store(Request $request)
    {
        News::create($request->all());
        return redirect('/admin/news');
    }

    public function edit($id)
    {
        $item = News::find($id);
        return view('admin.news.edit',compact('item'));
    }


    public function update(Request $request, $id)
    {

        $news = News::find($id);
        $news->update($request->all());

        return redirect('/admin/news');
    }


    public function destroy($id)
    {
        News::destroy($id);
        return redirect('/admin/news');
    }
}
