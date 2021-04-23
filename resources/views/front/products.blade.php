@extends('layouts.front_layout')

@section('css')
<style>
    .bg-img {
        background-image: url("https://cdn.pixabay.com/photo/2018/05/28/23/28/nature-3437545_960_720.jpg");
        height: 500px;
        background-size: cover;
        background-position: center;
        margin-bottom: 60px;
    }

    .card {
        overflow: hidden;
        margin-bottom: 30px;
    }

    .card img {
        transition: 0.5s;
    }

    .card img:hover {
        transform: scale(1.05);
    }
</style>
@endsection

@section('content')

<div class="bg-img">

</div>

<div class="container">
    @foreach ($ProductTypes as $ProductType)
    <h1>{{ $ProductType->type_name}}</h1>
    <div class="row">
        @foreach ($ProductType->products as $product)
        <div class="col-4">
            <div class="card">
                <img src="{{$product->img}}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{$product->title}}</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's content.</p>
                    <a href="/products/{{$product->id}}" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
</div>

@endsection


@section('js')
@endsection
