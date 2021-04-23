@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">最新消息管理 - Create</div>

                <div class="card-body">
                    <form method="post" action="/admin/news/store" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">最新消息標題</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sort" class="col-sm-2 col-form-label">sort</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="inputEmail3" value="" name="sort" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="news_image" class="col-sm-2 col-form-label">Img</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="news_image" value="" name="news_image" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">SEND</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
@endsection
