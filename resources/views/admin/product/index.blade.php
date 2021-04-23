@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">產品管理 - Index</div>

                <div class="card-body">
                    <a class="btn btn-success" href="/admin/product/create">新增產品</a>
                    <hr>

                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>產品類別</th>
                                <th>標題(title)</th>
                                <th>排序(sort)</th>
                                <th>圖片(img)</th>
                                <th>售價(price)</th>
                                <th width="120">功能</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->productType->type_name}}</td>
                                <td>{{ $item->title}}</td>
                                <td>{{ $item->sort}}</td>
                                <td><img width="250" src="{{$item->img}}" alt=""></td>
                                <td>{{ $item->price}}</td>
                                <td>
                                    <a class="btn btn-success btn-sm" href="/admin/product/edit/{{ $item->id}}">編輯</a>
                                    <a class="btn btn-danger btn-sm" href="#" data-itemid="{{$item->id}}">刪除</a>

                                    <form class="destroy-form" data-itemid="{{$item->id}}"
                                        action="/admin/product/destroy/{{$item->id}}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "order": [1,"desc"]
        });

        $('#example').on('click','.btn-danger',function(){
            event.preventDefault();
            var r = confirm("你確定要刪除此項目嗎?");
            if (r == true) {
                var itemid = $(this).data("itemid");
                $(`.destroy-form[data-itemid="${itemid}"]`).submit();
            }
        });
    });
</script>
@endsection
