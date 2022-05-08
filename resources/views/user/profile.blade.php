@extends('layouts.master')
@section('title','Profile')
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
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Update Profile</h3>
                </div>
                <!-- /.card-header -->
                <form method="POST" action="{{ route('user.updateProfile', ['id' => Auth::id()])}}) }}" class="needs-validation update-profile">
                    <div class="card-body">
                        <div class="col-md-12">
                            <input type="hidden" class="form-control" id="user_id" name="user_id"
                            value="{{ $user_data->id }}">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{ strtoupper($user_data->username) }}" readonly>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="fullname">Nama User</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" value="{{ $user_data->fullname }}">
                                <small id="errorName" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user_data->email }}">
                                <small id="errorEmail" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="phone">Nomor Telpon</label>
                                <input type="number" class="form-control" id="phone" name="phone" value="{{ $user_data->phone }}">
                                <small id="errorPhone" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info float-right" id="updateProfile">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Ubah Kata Sandi</h3>
                </div>
                <!-- /.card-header -->
                <form method="post" action="{{ route('user.changePassword', ['id' => Auth::id()])}}) }}" class="needs-validation change-password">
                    @csrf
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="current_password">Password Lama</label>
                                <input type="password" class="form-control" id="current_password" name="current_password"
                                    placeholder="*****">
                                <small id="errorCurrentPass" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="new_password">Password Baru</label>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    placeholder="*****">
                                <small id="errorNewPass" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="confirm_password">Ulangi Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                    placeholder="*****">
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info float-right" id="changePassword">Simpan</button>
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
    // function pageRedirect
    function pageRedirect() {
        window.location = "{{ route('auth') }}";
    }
    // update profile
    $(document).on("click", "#updateProfile", function (e) {
        e.preventDefault();

        var id = $("#user_id").val();
        var username = $("#username").val();
        var fullname = $("#fullname").val();
        var email = $("#email").val();
        var phone = $("#phone").val();

        var fd = new FormData();
        fd.append("id", id);
        fd.append("username", username);
        fd.append("fullname", fullname);
        fd.append("email", email);
        fd.append("phone", phone);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: $('.update-profile').attr('action'),
            type: $('.update-profile').attr('method'),
            dataType: "JSON",
            processData: false,
            contentType: false,
            data: fd,
            success: function(responce){
                // console.log(responce);
                if(responce.success == 200){
                    Toast.fire({
                        icon: 'success',
                        title: 'Yeay..!',
                        text: responce.message
                    });
                    $(".user-fullname").html(responce.data.fullname)
                    $(".user-email").html(responce.data.email)
                }else{
                    if (responce.message.fullname){
                        $('#fullname').addClass('is-invalid');
                        $('#errorName').html(responce.message.fullname);
                    } else {
                        $('#fullname').removeClass('is-invalid');
                        $('#fullname').addClass('');
                        $('#errorName').html('');
                    }
                    if (responce.message.email){
                        $('#email').addClass('is-invalid');
                        $('#errorEmail').html(responce.message.email);
                    } else {
                        $('#email').removeClass('is-invalid');
                        $('#email').addClass('');
                        $('#errorEmail').html('');
                    }
                    if (responce.message.phone){
                        $('#phone').addClass('is-invalid');
                        $('#errorPhone').html(responce.message.phone);
                    } else {
                        $('#phone').removeClass('is-invalid');
                        $('#phone').addClass('');
                        $('#errorPhone').html('');
                    }
                }
            }
        })
    })
    // update kata sandi
    $(document).on("click", "#changePassword", function(e){
        e.preventDefault();

        var id = $("#user_id").val();
        var current_password = $("#current_password").val();
        var new_password = $("#new_password").val();
        var confirm_password = $("#confirm_password").val();

        var fd = new FormData();
        fd.append("id", id);
        fd.append("current_password", current_password);
        fd.append("new_password", new_password);
        fd.append("confirm_password", confirm_password);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: $('.change-password').attr('action'),
            type:  $('.change-password').attr('method'),
            dataType: "JSON",
            processData: false,
            contentType: false,
            data: fd,
            success: function(responce){
                console.log(responce);
                if (responce.success == 400){
                    if (responce.message.current_password) {
                        $('#current_password').addClass('is-invalid');
                        $('#errorCurrentPass').html(responce.message.current_password);
                    } else {
                        $('#current_password').removeClass('is-invalid');
                        $('#current_password').addClass('');
                        $('#errorCurrentPass').html('');
                    }
                    if (responce.message.new_password) {
                        $('#new_password').addClass('is-invalid');
                        $('#errorNewPass').html(responce.message.new_password);
                    } else {
                        $('#new_password').removeClass('is-invalid');
                        $('#new_password').addClass('');
                        $('#errorNewPass').html('');
                    }
                    if (responce.message.confirm_password) {
                        $('#confirm_password').addClass('is-invalid');
                        $('#errorConfrimPass').addClass('');
                        $('#errorConfrimPass').html(responce.message.confirm_password);
                        $('#new_password').addClass('is-invalid');
                        $('#errorNewPass').addClass('');
                        $('#errorNewPass').html(responce.message.confirm_password);
                    } else {
                        $('#confirm_password').removeClass('is-invalid');
                        $('#confirm_password').addClass('');
                        $('#errorConfrimPass').removeClass('');
                        $('#errorConfrimPass').html('');
                    }
                } else if (responce.success == 401){
                    Toast.fire({
                        icon: 'error',
                        title: 'Oops..!',
                        text: responce.message
                    })
                } else {
                    if (responce.success == 200){
                        Toast.fire({
                            icon: 'success',
                            title: 'Yeay..!',
                            text: responce.message
                        });
                        setTimeout('pageRedirect()', 3000);
                    }
                }
            }
        })
    })
</script>
@endpush
