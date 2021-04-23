@extends('layouts.front_layout')

@section('css')
<link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endsection

@section('content')
  <section>
      <div class="banner">
        <div class="swiper-container banner-container">
          <div class="swiper-wrapper">
            <div class="swiper-slide"><img width="100%" src="https://i.kym-cdn.com/entries/icons/mobile/000/031/843/salamicat.jpg" alt=""></div>
            <div class="swiper-slide"><img width="100%" src="https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/womanyellingcat-1573233850.jpg" alt=""></div>
            <div class="swiper-slide"><img width="100%" src="https://i.kym-cdn.com/entries/icons/mobile/000/031/843/salamicat.jpg" alt=""></div>
          </div>
          <!-- Add Arrows -->
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>
      </div>
  </section>
  <section>
    <div class="container">
      <h2>PRODUCT</h2>
      <div class="product-card">
        <div class="product">
          @foreach($products as $product)
          <div class="card" style="width: 18rem;">
            <img src="{{$product->img}}" class="card-img-top" alt="">
            <div class="card-body">
              <h5 class="card-title">{{$product->title}}</h5>
              <p class="card-text">{{$product->description}}</p>
              <a href="/products/{{$product->id}}" class="btn btn-primary">Go somewhere</a>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

<section>
  <div class="container">
    <h2>NEWS</h2>

    @foreach($news as $new)
      <a href="/news/{{$new->id}}">
        <div class="news">
          <span>{{$new->created_at}}</span>
          <span>|</span>
          <span>{{$new->title}}</span>
        </div>
      </a>
    @endforeach
  </div>
</section>



@endsection


@section('js')

<script>
  var swiper = new Swiper('.banner-container', {
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    loop:true,
  });
</script>

@endsection
