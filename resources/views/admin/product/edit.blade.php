@extends('layouts.app')

@section('css')
<style>
    .product_imgs {
        position: relative;
    }

    .product_imgs .btn-danger {
        border-radius: 50%;
        position: absolute;
        right: 5px;
        top: 5px;
    }

    .product_imgs .sort {
        display: flex;
        margin-top: 5px;
    }

    .product_imgs label {
        margin: 0 5px;
        line-height: 37px;
    }

    .product_imgs input {
        width: 100%;
    }

    .grid {
        position: relative;
        min-height: 120px;
    }

    .item {
        display: block;
        position: absolute;
        width: 100px;
        height: 100px;
        margin: 5px;
        z-index: 1;
    }

    .item.muuri-item-dragging {
        z-index: 3;
    }

    .item.muuri-item-releasing {
        z-index: 2;
    }

    .item.muuri-item-hidden {
        z-index: 0;
    }

    .item-content {
        position: relative;
        width: 100%;
        height: 100%;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">產品管理 - Edit</div>

                <div class="card-body">
                    <form method="post" action="/admin/product/update/{{$item->id}}" enctype="multipart/form-data">
                        @csrf

                        <input type="text" id="new_sort" name="new_sort" value="" hidden>

                        <div class="form-group row">
                            <label for="type_id" class="col-sm-2 col-form-label">產品類別</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="type_id" id="type_id">
                                    @foreach ($productTypes as $productType)
                                    <option value="{{ $productType->id }}" @if($item->type_id === $productType->id)
                                        selected @endif>{{ $productType->type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="img" class="col-sm-2 col-form-label">現有產品圖片</label>
                            <div class="col-sm-10">
                                <img class="img-fluid" src="{{$item->img}}" alt="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="img" class="col-sm-2 col-form-label">重新上傳產品圖片 <br><small
                                    class="text-danger">*建議圖片尺寸500px(寬)*700px(高)</small></label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="img" value="" name="img">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="img" class="col-sm-2 col-form-label">現有產品組圖片</label>
                            <div class="col-sm-10">
                                <div class="grid">
                                    @foreach ($item->product_imgs as $product_img)
                                    <div class="item" data-productimgid="{{$product_img->id}}">
                                        <div class="item-content">
                                            <div class="product_imgs" data-productimgid="{{$product_img->id}}">
                                                <img class="img-fluid" src="{{$product_img->img}}" alt="">
                                                <button class="btn btn-danger btn-sm"
                                                    data-productimgid="{{$product_img->id}}" type="button">X</button>
                                                <div class="sort">
                                                    <label for="imgs">Sort</label>
                                                    <input class="form-control"
                                                        onchange="post_ajax_sort(this,{{$product_img->id}})"
                                                type="text" value="{{$product_img->sort}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="img" class="col-sm-2 col-form-label">重新上傳產品組圖片 <br><small
                                    class="text-danger">*建議圖片尺寸500px(寬)*700px(高)</small></label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="imgs" name="imgs[]" multiple>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">標題</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" value="{{$item->title}}" name="title"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-2 col-form-label">敘述</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="description" id="description"
                                    rows="5">{{$item->description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sort" class="col-sm-2 col-form-label">排序(sort)</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="sort" value="{{$item->sort}}" name="sort"
                                    value="1" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-sm-2 col-form-label">售價(price)</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="price" name="price" value="{{$item->price}}" required>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary">SEND</button>
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
<script src="https://unpkg.com/web-animations-js@2.3.2/web-animations.min.js"></script>
<script src="https://unpkg.com/muuri@0.8.0/dist/muuri.min.js"></script>
<script>
    $(document).ready(function() {
        var grid = new Muuri('.grid',{
            dragEnabled: true,
        }).on('move', function () {
            getOrder(grid);
        });


        function getOrder(grid) {
            var currentItems = grid.getItems();
            var currentItemIds = currentItems.map(function (item) {
                return item.getElement().getAttribute('data-productimgid')
            });
            $('#new_sort').val(currentItemIds.join());
        }


        $('#description').summernote({
            height: 150,
            lang: 'zh-TW',
            callbacks: {
                onImageUpload: function(files) {
                    for(let i=0; i < files.length; i++) {
                        $.upload(files[i]);
                    }
                },
                onMediaDelete : function(target) {
                    $.delete(target[0].getAttribute("src"));
                }
            },
        });


        $.upload = function (file) {
            let out = new FormData();
            out.append('file', file, file.name);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'POST',
                url: '/admin/ajax_upload_img',
                contentType: false,
                cache: false,
                processData: false,
                data: out,
                success: function (img) {
                    $('#description').summernote('insertImage', img);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " " + errorThrown);
                }
            });
        };

        $.delete = function (file_link) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'POST',
                url: '/admin/ajax_delete_img',
                data: {file_link:file_link},
                success: function (img) {
                    console.log("delete:",img);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " " + errorThrown);
                }
            });
        }

        $('.product_imgs .btn-danger').click(function () {

            var product_imgs_id = $(this).data('productimgid');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'POST',
                url: '/admin/ajax_delete_product_imgs',
                data: {product_imgs_id: product_imgs_id},
                success: function (res) {
                    $( `.product_imgs[data-productimgid='${product_imgs_id}']` ).remove();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " " + errorThrown);
                }
            });
        });
    });


    function post_ajax_sort(element,product_imgs_id) {
        var product_imgs_id;
        var sort_value = element.value;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: 'POST',
            url: '/admin/ajax_sort_product_imgs',
            data: {product_imgs_id: product_imgs_id,sort_value: sort_value},
            success: function (res) {

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(textStatus + " " + errorThrown);
            }
        });
    }
</script>
@endsection
