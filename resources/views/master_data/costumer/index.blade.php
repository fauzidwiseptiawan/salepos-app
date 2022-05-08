@extends('layouts.master')
@section('title', 'Daftar Pelanggan')
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
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add-costumer">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Tambah Pelanggan
                </button>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-import-costumer">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Import Pelanggan
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table-costumer" class="table" width="100%">
                    <thead>
                        <tr>
                            <th class="not-exported" width=5%>
                                <input class="checkmark select-form" type="checkbox" name="select_all" id="select_all">
                            </th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th class="not-exported" width="13%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <!-- /.container-fluid -->
    <!-- /.content -->

    {{-- modals tambah costumer --}}
    <div class="modal fade" id="modal-add-costumer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah costumer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body text-alert">
                    Label bidang yang ditandai dengan * adalah bidang input wajib.
                </div>
                <form method="POST" action="{{ route('costumerlist.store') }}" class="needs-validation add-costumer">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="costumerCode">Kode *</strong></label>
                                        <input type="text" class="form-control" id="costumerCode" name="costumer_code">
                                        <small id="errorcostumerCode" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="costumerName">Nama *</strong></label>
                                        <input type="text" class="form-control" id="costumerName" name="costumer_name">
                                        <small id="errorcostumerName" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Telpon *</strong></label>
                                        <input type="number" class="form-control" id="phone" name="phone">
                                        <small id="errorPhone" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                        <small id="errorEmail" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">Kota</label>
                                        <input type="text" class="form-control" id="city" name="city">
                                        <small id="errorCity" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="province">Provinsi</label>
                                        <input type="text" class="form-control" id="province" name="province">
                                        <small id="errorProvince" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="desc">Keterangan</label>
                                        <textarea class="form-control" rows="3" id="desc" name="desc"></textarea>
                                        <small id="errorDesc" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Alamat</label>
                                        <textarea class="form-control" rows="3" id="address" name="address"></textarea>
                                        <small id="errorAddress" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" id="addcostumer">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    {{-- modals edit costumer --}}
    <div class="modal fade" id="modal-update-costumer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit costumer : <span id="costumerTitle">test</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body text-alert">
                    Label bidang yang ditandai dengan * adalah bidang input wajib.
                </div>
                <form method="POST" class="needs-validation update-costumer">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="edtId">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edtcostumerCode">Kode *</strong></label>
                                        <input type="text" class="form-control" id="edtcostumerCode" name="costumer_code">
                                        <small id="errorEdtcostumerCode" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edtcostumerName">Nama *</strong></label>
                                        <input type="text" class="form-control" id="edtcostumerName" name="costumer_name">
                                        <small id="errorEdtcostumerName" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edtPhone">Telpon *</strong></label>
                                        <input type="number" class="form-control" id="edtPhone" name="phone">
                                        <small id="errorEdtPhone" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edtEmail">Email</label>
                                        <input type="email" class="form-control" id="edtEmail" name="email">
                                        <small id="errorEdtEmail" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edtCity">Kota</label>
                                        <input type="text" class="form-control" id="edtCity" name="city">
                                        <small id="errorEdtCity" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edtProvince">Provinsi</label>
                                        <input type="text" class="form-control" id="edtProvince" name="province">
                                        <small id="errorEdtProvince" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edtDesc">Keterangan</label>
                                        <textarea class="form-control" rows="3" id="edtDesc" name="desc"></textarea>
                                        <small id="errorEdtDesc" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edtAddress">Alamat</label>
                                        <textarea class="form-control" rows="3" id="edtAddress" name="address"></textarea>
                                        <small id="errorEdtAddress" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" id="updatecostumer">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    {{-- modals import costumer --}}
    <div class="modal fade" id="modal-import-costumer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import costumer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body text-alert">
                    Label bidang yang ditandai dengan * adalah bidang input wajib.
                </div>
                <form method="POST" action="{{ route('costumerlist.import') }}" class="needs-validation import-costumer"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="callout callout-info">
                            <p>Urutan kolom yang benar adalah (merek*, keterangan*) harus mengikuti ini.!</p>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="filecostumer">Unggah file CSV *</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file" class="custom-file-input" id="filecostumer">
                                                <label class="custom-file-label" for="filecostumer">Choose file</label>
                                            </div>
                                        </div>
                                        <small id="errorFile" class="form-text text-muted"></small>
                                        <span style="font-size: 13px">NB : Maksimum total data yang bisa diimport dalam
                                            sekali proses adalah 1000.</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="desc">Contoh file</label>
                                        <a href="contoh_file/contoh_import_costumer.xlsx"
                                            class="btn btn-primary btn-block"><i class="fa fa-download"></i> Unduh</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" id="importcostumer">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal -->
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

        // datatable fetch
        let table;
        let check = 0
        $(function() {
            table = $("#table-costumer").DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                dom: "<'row'<'col-md-3'l><'col-md-5 'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                ajax: {
                    url: "{{ route('costumerlist.fetch') }}",
                    type: "GET",
                },
                columns: [{
                        data: 'select_all',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'costumer_code'
                    },
                    {
                        data: 'costumer_name'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'address'
                    },
                    {
                        data: 'action',
                        searchable: false,
                        sortable: false
                    },
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                buttons: [{
                        text: '<i title="Hapus" class="fas fa-times"></i>',
                        action: function(e, dt, node, config) {
                            let selected = $("#table-costumer tbody .select-form:checked")
                            let id = []
                            // looping row selected
                            $.each(selected, function(index, responce) {
                                id.push(responce.value)
                            })
                            if ($('.select-form:checked').length > 0) {
                                Swal.fire({
                                    title: 'Apakah kamu yakin?',
                                    text: "Anda tidak akan dapat mengembalikan data ini!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, Hapus!',
                                    cancelButtonText: 'Tidak',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $(
                                                        'meta[name="csrf-token"]')
                                                    .attr('content')
                                            }
                                        });
                                        $.ajax({
                                            url: "{{ route('costumerlist.destroySelected') }}",
                                            type: 'POST',
                                            data: {
                                                id: id
                                            },
                                            success: function(responce) {
                                                if (responce.success == 200) {
                                                    Toast.fire({
                                                        icon: 'success',
                                                        title: 'Yeay..!',
                                                        text: responce
                                                            .message
                                                    });
                                                }
                                                $('#modal-import-costumer')
                                                    .modal(
                                                        'hide');
                                                table.ajax.reload();
                                            }
                                        })
                                    }
                                })
                            } else {
                                Toast.fire({
                                    icon: 'warning',
                                    title: 'Oops..!',
                                    text: 'Tidak ada merek yang dipilih!'
                                });
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i title="ekspor ke pdf" class="far fa-file-pdf"></i>',
                        action: function(e, dt, node, config) {
                            var data = '';
                            $.ajax({
                                url: `{{ route('costumerlist.exportPDF') }}`,
                                type: "GET",
                                data: data,
                                success: function(responce) {
                                    if (responce.success == 200) {
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Yeay..!',
                                            text: responce.message
                                        });
                                    }
                                }
                            })
                        }
                    },
                    {
                        extend: 'print',
                        autoPrint: false,
                        text: '<i title="Print" class="fas fa-print"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible',
                            stripHtml: false
                        },
                    },
                    {
                        extend: 'csv',
                        text: '<i title="ekspor ke csv" class="far fa-file-alt"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible',
                        },
                    },
                    {
                        extend: 'colvis',
                        text: '<i title="column visibility" class="fa fa-eye"></i>',
                        columns: ':gt(0)'
                    },
                ]
            });
            table.buttons().container()
                .appendTo('#table-costumer_wrapper .col-md-5:eq(0)');
        })

        // function select all
        $("#select_all").on('click', function() {
            var isChecked = $("#select_all").prop('checked')
            $(".select-form").prop('checked', isChecked)
        })
        // end function

        // function select one
        $("#table-costumer tbody").on('click', '.select-form', function() {
            if ($(this).prop('checked') != true) {
                $("#select_all").prop('checked', false)
            }
            let selectAll = $("#table-costumer tbody .select-form:checked")
            let deleteSelected = (selectAll.length > 0)
        })
        // end function

        // add costumer
        $(document).on("click", "#addcostumer", function(e) {
            e.preventDefault();

            var costumer_code = $("#costumerCode").val();
            var costumer_name = $("#costumerName").val();
            var phone = $("#phone").val();
            var city = $("#city").val();
            var province = $("#province").val();
            var email = $("#email").val();
            var address = $("#address").val();
            var desc = $("#desc").val();

            var fd = new FormData();
            fd.append("costumer_code", costumer_code);
            fd.append("costumer_name", costumer_name);
            fd.append("phone", phone);
            fd.append("email", email);
            fd.append("city", city);
            fd.append("province", province);
            fd.append("address", address);
            fd.append("desc", desc);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: $('.add-costumer').attr('action'),
                type: $('.add-costumer').attr('method'),
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
                        $('#modal-add-costumer').modal('hide')
                        $('.add-costumer')[0].reset()
                        table.ajax.reload();
                    } else {
                        if (responce.message.costumer_code) {
                            $('#costumerCode').addClass('is-invalid');
                            $('#errorcostumerCode').html(responce.message.costumer_code);
                        } else {
                            $('#costumerCode').removeClass('is-invalid');
                            $('#costumerCode').addClass('');
                            $('#errorcostumerCode').html('');
                        }
                        if (responce.message.costumer_name) {
                            $('#costumerName').addClass('is-invalid');
                            $('#errorcostumerName').html(responce.message.costumer_name);
                        } else {
                            $('#costumerName').removeClass('is-invalid');
                            $('#costumerName').addClass('');
                            $('#errorcostumerName').html('');
                        }
                        if (responce.message.phone) {
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

        // show data costumer
        $(document).on("click", "#show", function(e) {
            e.preventDefault();

            var id = $(this).attr("value");
            var url = "{{ route('costumerlist.show', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: "GET",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(responce) {
                    $('#modal-update-costumer').modal('show');
                    $('#costumerTitle').text(responce.data.costumer_name);
                    $('#edtId').val(responce.data.id);
                    $('#edtcostumerCode').val(responce.data.costumer_code);
                    $('#edtcostumerName').val(responce.data.costumer_name);
                    $('#edtPhone').val(responce.data.phone);
                    $('#edtEmail').val(responce.data.email);
                    $('#edtCity').val(responce.data.city);
                    $('#edtProvince').val(responce.data.province);
                    $('#edtAddress').val(responce.data.address);
                    $('#edtDesc').val(responce.data.desc);
                }
            })
        })

        // add costumer
        $(document).on("click", "#updatecostumer", function(e) {
            e.preventDefault();

            var method = $("input[name='_method']").attr('value');
            var id = $("#edtId").val();
            var costumer_code = $("#edtcostumerCode").val();
            var costumer_name = $("#edtcostumerName").val();
            var city = $("#edtCity").val();
            var province = $("#edtProvince").val();
            var phone = $("#edtPhone").val();
            var email = $("#edtEmail").val();
            var address = $("#edtAddress").val();
            var desc = $("#edtDesc").val();

            var url = "{{ route('costumerlist.update', ':id') }}";
            url = url.replace(':id', id);

            var fd = new FormData();
            fd.append("_method", method)
            fd.append("id", id);
            fd.append("costumer_code", costumer_code);
            fd.append("costumer_name", costumer_name);
            fd.append("phone", phone);
            fd.append("email", email);
            fd.append("city", city);
            fd.append("province", province);
            fd.append("address", address);
            fd.append("desc", desc);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                type: $('.update-costumer').attr('method'),
                dataType: "JSON",
                processData: false,
                contentType: false,
                data: fd,
                success: function(responce) {
                    if (responce.success == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Yeay..!',
                            text: responce.message
                        });
                        $('#modal-update-costumer').modal('hide');
                        table.ajax.reload();
                    } else {
                        if (responce.message.costumer_code) {
                            $('#edtcostumerCode').addClass('is-invalid');
                            $('#errorEdtcostumerCode').html(responce.message.costumer_code);
                        } else {
                            $('#edtcostumerCode').removeClass('is-invalid');
                            $('#edtcostumerCode').addClass('');
                            $('#errorEdtcostumerCode').html('');
                        }
                        if (responce.message.costumer_name) {
                            $('#edtcostumerName').addClass('is-invalid');
                            $('#errorEdtcostumerName').html(responce.message.costumer_name);
                        } else {
                            $('#edtcostumerName').removeClass('is-invalid');
                            $('#edtcostumerName').addClass('');
                            $('#errorEdtcostumerName').html('');
                        }
                        if (responce.message.phone) {
                            $('#edtPhone').addClass('is-invalid');
                            $('#errorEdtPhone').html(responce.message.phone);
                        } else {
                            $('#edtPhone').removeClass('is-invalid');
                            $('#edtPhone').addClass('');
                            $('#errorEdtPhone').html('');
                        }
                    }
                }
            })
        })

        // import costumer
        $(document).on("click", "#importcostumer", function(e) {
            e.preventDefault()

            var file = $("#filecostumer")[0].files[0];

            var fd = new FormData();
            fd.append("file", file)

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: $('.import-costumer').attr('action'),
                type: $('.import-costumer').attr('method'),
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
                        table.ajax.reload();
                    }
                }
            })
        })

        // delete data costumer
        $(document).on("click", "#delete", function(e) {
            e.preventDefault();

            var id = $(this).attr("value");

            var url = "{{ route('costumerlist.destroy', ':id') }}";
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Anda tidak akan dapat mengembalikan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        dataType: "JSON",
                        processData: false,
                        contentType: false,
                        success: function(responce) {
                            if (responce.success == 200) {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Yeay..!',
                                    text: responce.message
                                });
                            }
                            table.ajax.reload();
                        }
                    })
                }
            })
        })
    </script>
@endpush
