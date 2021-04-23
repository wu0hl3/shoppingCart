@extends('layouts.front_layout')

@section('css')
<style>
    .bg-img {
        background-image: url("https://cdn.pixabay.com/photo/2019/11/10/11/31/landscape-4615578_960_720.jpg");
        height: 500px;
        background-size: cover;
        background-position: center;
        margin-bottom: 60px;
    }

    .list-group-item a{
        display: block;
        width: 100%;
    }
</style>
@endsection

@section('content')

<div class="bg-img">
</div>

<div class="container">
    <ul class="list-group">
        @foreach ($items as $item)
        <li class="list-group-item d-flex">
            <a href="/news/{{ $item->id }}">
                <div>ID:  {{ $item->id }}</div>
                <div class="date mr-5">2019-05-03</div>
                <div class="news-title">{{ $item->title }}</div>
            </a>
        </li>
        @endforeach
    </ul>

    {{ $items->links() }}

</div>

@endsection


@section('js')
@endsection
