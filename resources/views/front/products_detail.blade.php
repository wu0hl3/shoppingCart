@extends('layouts.front_layout')

@section('css')
<style>
    .swiper-container {
        width: 100%;
        height: 100%;
    }

    .main-cotent {
        margin-top: 60px;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/css/swiper.min.css">
@endsection

@section('content')
<div class="container main-cotent">
    <div class="row">
        <div class="col-12 col-md-6">
            <!-- Swiper -->
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach ($product->product_imgs as $product_img)
                    <div class="swiper-slide">
                        <img class="img-fluid" src="{{ $product_img->img }}" alt="">
                    </div>
                    @endforeach
                </div>
                <!-- Add Arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <h1>{{ $product->title }}</h1>
            <p>{!! $product->description !!}</p>
            <button class="btn btn-primary add-cart" data-productid="{{ $product->id }}">加入購物車</button>
        </div>
    </div>
</div>
@endsection


@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/js/swiper.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });

    $('.add-cart').click(function(){
        var product_id = $(this).data("productid");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: 'POST',
            url: '/addCart',
            data: {product_id:product_id},
            success: function (res) {
                console.log("cartTotalQuantity:",res);
                //update cartTotalQuantity
                $('#cartTotalQuantity').text(res);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(textStatus + " " + errorThrown);
            }
        });
    });

</script>
@endsection
