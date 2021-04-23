@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">訂單管理 - Index</div>

                <div class="card-body">
                    <a class="btn btn-primary" href="/admin/order/select/new_order">未完成交易訂單</a>
                    <a class="btn btn-primary" href="/admin/order/select/payment_done">已完成付款</a>
                    <a class="btn btn-primary" href="/admin/order/select/ship_done">已出貨</a>
                    <hr>

                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>訂單編號</th>
                                <th>訂購人姓名</th>
                                <th>訂購人電話號碼</th>
                                <th>Price</th>
                                <th>訂單狀態</th>
                                <th width="200">功能</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->order_no}}</td>
                                <td>{{ $item->receive_name}}</td>
                                <td>{{ $item->receive_mobile}}</td>
                                <td>{{ $item->total_price}}</td>
                                <td>
                                    @if($item->status == "new_order")
                                    <span class="badge badge-warning">未完成交易訂單</span>
                                    @elseif($item->status == "payment_done")
                                    <span class="badge badge-primary">已完成付款</span>
                                    @elseif($item->status == "ship_done")
                                    <span class="badge badge-success">已出貨</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->status == "payment_done")
                                    <a class="btn btn-primary btn-sm" href="#"
                                        data-itemid="{{$item->order_no}}">改為出貨</a>

                                    <form class="ship-form" data-itemid="{{$item->order_no}}"
                                        action="/admin/order/changeStatus/{{$item->order_no}}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                    @endif

                                    <a class="btn btn-success btn-sm"
                                        href="/admin/order/show/{{$item->order_no}}">詳細內容</a>

                                    <a class="btn btn-danger btn-sm" href="#" data-itemid="{{$item->order_no}}">刪除訂單</a>
                                    <form class="destroy-form" data-itemid="{{$item->order_no}}"
                                        action="/admin/order/destroy/{{$item->order_no}}" method="POST"
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

        $('#example').on('click','.btn-primary',function(){
            event.preventDefault();
            var r = confirm("確認商品已送出嗎?將改為出貨狀態");
            if (r == true) {
                var itemid = $(this).data("itemid");
                $(`.ship-form[data-itemid="${itemid}"]`).submit();
            }
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
