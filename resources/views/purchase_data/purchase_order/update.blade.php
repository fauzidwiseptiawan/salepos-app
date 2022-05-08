@extends('layouts.master')
@section('title', 'Merek')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@yield('title')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Edit Merek : {{ $brand->brand }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body font-italic" style="margin-bottom: -3%">
                        <div class="alert alert-light" role="alert">
                            Label bidang yang ditandai dengan * adalah bidang input wajib.
                        </div>
                    </div>
                    <form method="POST" action="{{ route('brandlist.update', $brand->id) }}"
                        class="needs-validation update-brand" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" id="brand_id" value="{{ $brand->id }}">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="brand">Merek *</strong></label>
                                            <input type="text" class="form-control" id="brand" name="brand"
                                                value="{{ $brand->brand }}">
                                            <small id="errorBrand" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="desc">Keterangan *</strong></label>
                                            <input type="text" class="form-control" id="desc" name="desc"
                                                value="{{ $brand->desc }}">
                                            <small id="errorDesc" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">File input</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                            </div>
                                            <small id="errorImg" class="form-text text-muted"></small>
                                            <span id="errorDesc" style="font-size: 13px">NB : ukuran gambar = 125x125</span>
                                        </div>
                                    </div>
                                    @if ($brand->image)
                                        <div class="col-md-6">
                                            <img src="{{ asset('storage/brand-image/' . $brand->image) }}" width="50%"
                                                id="box" class="rounded mx-auto d-block"
                                                alt="{{ asset('storage/brand-image/' . $brand->image) }}">
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            <img src="{{ asset('template/dist/img/default.png') }}" width="50%" id="box"
                                                class="rounded mx-auto d-block"
                                                alt="{{ asset('template/dist/img/default.png') }}">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right" id="updateBrand">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    <!-- /.content -->
@endsection

@push('page-scripts')
@endpush

@push('after-scripts')
    <script>
        // show sweetalert
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        // Check the file image type
        if ($("#image").val() == '') {

        } else {
            if (!image.type.match('image.*')) {
                $('#image').addClass('is-invalid');
                $('#errorImg').html('Format harus image!')
            } else {
                $('#image').addClass('');
                $('#errorImg').html('')
            }
        }

        // function pageRedirect
        function pageRedirect() {
            window.location = "{{ route('brandlist.index') }}";
        }

        // costume file input
        $('.custom-file-input').on('change', function() {
            let filename = $(this).val().split('\\').pop();
            // console.log(filename);
            $(this).next('.custom-file-label').addClass("selected").html(filename);
        });

        var input = document.getElementById('image');
        input.addEventListener('change', function(input) {
            var box = document.getElementById('box');
            var image = input.target.files;

            var reader = new FileReader();
            reader.onload = function(e) {
                box.setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(image[0]);
        });

        // update brand
        $(document).on("click", "#updateBrand", function(e) {
            e.preventDefault();

            var method = $("input[name='_method']").attr('value');
            var id = $("#brand_id").val();
            var brand = $("#brand").val();
            var desc = $("#desc").val();
            var image = $("#image")[0].files[0];

            var fd = new FormData();
            fd.append("_method", method)
            fd.append("id", id);
            fd.append("brand", brand);
            fd.append("desc", desc);
            fd.append("image", image);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: $('.update-brand').attr('action'),
                type: $('.update-brand').attr('method'),
                dataType: "JSON",
                processData: false,
                contentType: false,
                data: fd,
                success: function(responce) {
                    console.log(responce);
                    if (responce.success == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Yeay..!',
                            text: responce.message
                        });
                        setTimeout('pageRedirect()', 2000);
                    } else {
                        if (responce.message.brand) {
                            $('#brand').addClass('is-invalid');
                            $('#errorBrand').html(responce.message.brand);
                        } else {
                            $('#brand').removeClass('is-invalid');
                            $('#brand').addClass('');
                            $('#errorBrand').html('');
                        }
                        if (responce.message.desc) {
                            $('#desc').addClass('is-invalid');
                            $('#errorDesc').html(responce.message.desc);
                        } else {
                            $('#desc').removeClass('is-invalid');
                            $('#desc').addClass('');
                            $('#errorDesc').html('');
                        }
                        if (responce.message.image) {
                            $('#image').addClass('is-invalid');
                            $('#errorImg').html(responce.message.image);
                        } else {
                            $('#image').removeClass('is-invalid');
                            $('#image').addClass('');
                            $('#errorImg').html('');
                        }
                    }
                }
            })
        })
    </script>
@endpush
