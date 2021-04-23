@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">訂單管理 - Show</div>

                <div class="card-body">
                    <ul>
                        @foreach ($order->orderItems as $item)
                        <li>{{$item->product->title}} x {{$item->qty}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>
</script>
@endsection
