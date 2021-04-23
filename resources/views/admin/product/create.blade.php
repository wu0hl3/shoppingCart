@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">產品管理 - Create</div>

                <div class="card-body">
                    <form method="post" action="/admin/product/store" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="type_id" class="col-sm-2 col-form-label">產品類別</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="type_id" id="type_id">
                                    @foreach ($productTypes as $productType)
                                    <option value="{{ $productType->id }}">{{ $productType->type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="img" class="col-sm-2 col-form-label">主要圖片(單一照片) <br><small
                                    class="text-danger">*建議圖片尺寸500px(寬)*700px(高)</small></label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="img" value="" name="img" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="imgs" class="col-sm-2 col-form-label">圖片組 <br><small
                                    class="text-danger">*建議圖片尺寸500px(寬)*700px(高)</small></label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="imgs" name="imgs[]" multiple required>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">標題</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-2 col-form-label">敘述</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="description" id="description" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sort" class="col-sm-2 col-form-label">排序(sort)</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="sort" name="sort" value="1" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-sm-2 col-form-label">售價(price)</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="price" name="price" value="1" required>
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
<script>
    $(document).ready(function() {
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
   });
</script>
@endsection
