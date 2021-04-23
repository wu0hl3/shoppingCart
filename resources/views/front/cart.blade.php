@extends('layouts.front_layout')

@section('css')
@endsection

@section('content')
<div class="container">
    <h1>Cart結帳頁</h1>
    <div>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ProductName</th>
                    <th scope="col">Price</th>
                    <th scope="col">Qty</th>
                    <th scope="col">SubTotal</th>
                    <th width="50">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($content as $item)
                <tr>
                    <th scope="row">1</th>
                    <td>{{$item->name}}</td>
                    <td>{{$item->price}}</td>
                    <td><input type="text" value="{{$item->quantity}}" class="product_qty"
                            data-productid="{{$item->id}}"></td>
                    <td>{{$item->price * $item->quantity}}</td>
                    <td><button class="btn btn-danger btn-sm delete_product" data-productid="{{$item->id}}">X</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <div>
        <h2>總計:$ {{$total}}</h2>
    </div>
    <a class="text-center btn btn-success" href="cart_check_out">確定結帳</a>
</div>
@endsection

@section('js')
<script>
    $(".delete_product").on('click', function() {
        var product_id = this.getAttribute("data-productid");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: 'POST',
            url: '/deleteProductInCart',
            data: {
                product_id:product_id,
            },
            success: function (res) {
                document.location.reload(true);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(textStatus + " " + errorThrown);
            }
        });
    });

    $('.product_qty').on('change', function() {
        // console.log("onchangeValue:",this.value);
        // console.log("onchangeProductID:",this.getAttribute("data-productid"));
        var new_qty = this.value;
        var product_id = this.getAttribute("data-productid");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: 'POST',
            url: '/changeProductQty',
            data: {
                product_id:product_id,
                new_qty:new_qty
            },
            success: function (res) {
                document.location.reload(true);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(textStatus + " " + errorThrown);
            }
        });
    });
</script>
@endsection
