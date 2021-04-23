@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">產品類別 - Edit</div>

                <div class="card-body">
                    <form method="post" action="/admin/product_type/update/{{ $item->id }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="type_name" class="col-sm-2 col-form-label">產品類別標題</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="type_name" name="type_name"
                                    value="{{ $item->type_name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Edit</button>
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
