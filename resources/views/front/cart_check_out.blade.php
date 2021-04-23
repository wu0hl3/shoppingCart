@extends('layouts.front_layout')

@section('css')
<style>
    .cus-label {
        width: 75px;
    }

    .time_btn {
        padding: 3px 20px;
        border: 1px solid black;
        cursor: pointer;
    }

    .time_btn.active {
        background-color: black;
        color: white;
    }

    .time_btn:nth-child(2),
    .time_btn:nth-child(3) {
        border-left: none;
    }

    .form-btns {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        margin-bottom: 1rem;
    }

    .btn-send {
        border-radius: 0;
        width: 100%;
        background-color: white;
        color: black;
        margin-top: 20px;
        height: 40px;
        display: block;
    }
</style>
@endsection

@section('content')
<div class="container">
    <h1>CHECK</h1>
    <div>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ProductName</th>
                    <th scope="col">Price</th>
                    <th scope="col">Qty</th>
                    <th scope="col">SubTotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($content as $item)
                <tr>
                    <th scope="row">1</th>
                    <td>{{$item->name}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->price * $item->quantity}}</td>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <div>
        <h2>總計:$ {{$total}}</h2>
    </div>
    <hr>
    <form method="post" action="/send_check_out">
        @csrf
        <div class="row">
            <div class="col-12 col-md-10">
                <div class="form-group row">
                    <label for="receive_name" class="col-form-label cus-label">訂購姓名*</label>
                    <div class="col-sm">
                        <input type="text" class="form-control" id="receive_name" name="receive_name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="receive_phone" class="col-form-label cus-label">連絡電話*</label>
                    <div class="col-sm">
                        <input type="text" class="form-control" id="receive_phone" name="receive_phone" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="receive_mobile"
                        class="col-form-label cus-label">手&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;機*</label>
                    <div class="col-sm">
                        <input type="text" class="form-control" id="receive_mobile" name="receive_mobile" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="receive_address" class="col-form-label cus-label">收件地址*</label>
                    <div class="col-sm">
                        <input type="text" class="form-control" id="receive_address" name="receive_address" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="receive_email" class="col-form-label cus-label">電子郵件*</label>
                    <div class="col-sm">
                        <input type="email" class="form-control" id="receive_email" name="receive_email" required>
                    </div>
                </div>
                <fieldset class="form-group">
                    <div class="row">
                        <legend class="col-form-label cus-label pt-0">發票方式*</legend>
                        <div class="col-sm d-flex">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="receipt" id="receipt1"
                                    value="二聯式發票" checked>
                                <label class="form-check-label" for="receipt1">
                                    二聯式發票
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="receipt" id="receipt2"
                                    value="三聯式發票">
                                <label class="form-check-label" for="receipt2">
                                    三聯式發票
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="form-group row">
                    <div class="cus-label">送貨時間*</div>
                    <div class="col-sm d-flex">
                        <div class="time_btn active">皆可</div>
                        <div class="time_btn">中午前</div>
                        <div class="time_btn">下午</div>
                    </div>
                    <input type="text" id="time_btn_input" name="time_to_send" value="皆可" hidden>
                </div>
                <div class="form-group row">
                    <label for="remark" class="col-form-label cus-label">備註</label>
                    <div class="col-sm">
                        <textarea class="form-control" name="remark" id="remark" rows="5"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-2 form-btns">
                    <div>
                        <a href="/cart" class="btn btn-dark btn-send">
                            <i class="fas fa-chevron-left"></i>
                            確認購買清單
                        </a>
                        <button type="submit" class="btn btn-dark btn-send">
                            送出訂單資料
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('js')
<script>
    $(".time_btn").click(function () {
        $(".time_btn").removeClass('active');
        $(this).addClass('active');
        var time_value = this.textContent;
        $("#time_btn_input").val(time_value);
    });

</script>
@endsection
