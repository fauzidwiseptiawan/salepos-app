@extends('layouts.master')
@section('title', 'Daftar Supplier')
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
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add-supplier">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Tambah Supplier
                </button>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-import-supplier">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Import Supplier
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table-supplier" class="table" width="100%">
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

    {{-- modals tambah supplier --}}
    <div class="modal fade" id="modal-add-supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body text-alert">
                    Label bidang yang ditandai dengan * adalah bidang input wajib.
                </div>
                <form method="POST" action="{{ route('supplierlist.store') }}" class="needs-validation add-supplier">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="supplierCode">Kode *</strong></label>
                                        <input type="text" class="form-control" id="supplierCode" name="supplier_code">
                                        <small id="errorSupplierCode" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="supplierName">Nama *</strong></label>
                                        <input type="text" class="form-control" id="supplierName" name="supplier_name">
                                        <small id="errorSupplierName" class="form-text text-muted"></small>
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
                        <button type="submit" class="btn btn-info" id="addSupplier">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    {{-- modals edit supplier --}}
    <div class="modal fade" id="modal-update-supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit supplier : <span id="supplierTitle">test</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body text-alert">
                    Label bidang yang ditandai dengan * adalah bidang input wajib.
                </div>
                <form method="POST" class="needs-validation update-supplier">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="edtId">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edtSupplierCode">Kode *</strong></label>
                                        <input type="text" class="form-control" id="edtSupplierCode" name="supplier_code">
                                        <small id="errorEdtSupplierCode" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edtSupplierName">Nama *</strong></label>
                                        <input type="text" class="form-control" id="edtSupplierName" name="supplier_name">
                                        <small id="errorEdtSupplierName" class="form-text text-muted"></small>
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
                        <button type="submit" class="btn btn-info" id="updateSupplier">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    {{-- modals import supplier --}}
    <div class="modal fade" id="modal-import-supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body text-alert">
                    Label bidang yang ditandai dengan * adalah bidang input wajib.
                </div>
                <form method="POST" action="{{ route('supplierlist.import') }}" class="needs-validation import-supplier"
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
                                        <label for="filesupplier">Unggah file CSV *</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file" class="custom-file-input" id="filesupplier">
                                                <label class="custom-file-label" for="filesupplier">Choose file</label>
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
                                        <a href="contoh_file/contoh_import_supplier.xlsx"
                                            class="btn btn-primary btn-block"><i class="fa fa-download"></i> Unduh</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" id="importsupplier">Simpan</button>
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
            table = $("#table-supplier").DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                dom: "<'row'<'col-md-3'l><'col-md-5 'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                ajax: {
                    url: "{{ route('supplierlist.fetch') }}",
                    type: "GET",
                },
                columns: [{
                        data: 'select_all',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'supplier_code'
                    },
                    {
                        data: 'supplier_name'
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
                            let selected = $("#table-supplier tbody .select-form:checked")
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
                                            url: "{{ route('supplierlist.destroySelected') }}",
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
                                                $('#modal-import-supplier')
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
                                url: `{{ route('supplierlist.exportPDF') }}`,
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
                .appendTo('#table-supplier_wrapper .col-md-5:eq(0)');
        })

        // function select all
        $("#select_all").on('click', function() {
            var isChecked = $("#select_all").prop('checked')
            $(".select-form").prop('checked', isChecked)
        })
        // end function

        // function select one
        $("#table-supplier tbody").on('click', '.select-form', function() {
            if ($(this).prop('checked') != true) {
                $("#select_all").prop('checked', false)
            }
            let selectAll = $("#table-supplier tbody .select-form:checked")
            let deleteSelected = (selectAll.length > 0)
        })
        // end function

        // add supplier
        $(document).on("click", "#addSupplier", function(e) {
            e.preventDefault();

            var supplier_code = $("#supplierCode").val();
            var supplier_name = $("#supplierName").val();
            var phone = $("#phone").val();
            var city = $("#city").val();
            var province = $("#province").val();
            var email = $("#email").val();
            var address = $("#address").val();
            var desc = $("#desc").val();

            var fd = new FormData();
            fd.append("supplier_code", supplier_code);
            fd.append("supplier_name", supplier_name);
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
                url: $('.add-supplier').attr('action'),
                type: $('.add-supplier').attr('method'),
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
                        $('#modal-add-supplier').modal('hide')
                        $('.add-supplier')[0].reset()
                        table.ajax.reload();
                    } else {
                        if (responce.message.supplier_code) {
                            $('#supplierCode').addClass('is-invalid');
                            $('#errorSupplierCode').html(responce.message.supplier_code);
                        } else {
                            $('#supplierCode').removeClass('is-invalid');
                            $('#supplierCode').addClass('');
                            $('#errorSupplierCode').html('');
                        }
                        if (responce.message.supplier_name) {
                            $('#supplierName').addClass('is-invalid');
                            $('#errorSupplierName').html(responce.message.supplier_name);
                        } else {
                            $('#supplierName').removeClass('is-invalid');
                            $('#supplierName').addClass('');
                            $('#errorSupplierName').html('');
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

        // show data supplier
        $(document).on("click", "#show", function(e) {
            e.preventDefault();

            var id = $(this).attr("value");
            var url = "{{ route('supplierlist.show', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: "GET",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(responce) {
                    $('#modal-update-supplier').modal('show');
                    $('#supplierTitle').text(responce.data.supplier_name);
                    $('#edtId').val(responce.data.id);
                    $('#edtSupplierCode').val(responce.data.supplier_code);
                    $('#edtSupplierName').val(responce.data.supplier_name);
                    $('#edtPhone').val(responce.data.phone);
                    $('#edtEmail').val(responce.data.email);
                    $('#edtCity').val(responce.data.city);
                    $('#edtProvince').val(responce.data.province);
                    $('#edtAddress').val(responce.data.address);
                    $('#edtDesc').val(responce.data.desc);
                }
            })
        })

        // add supplier
        $(document).on("click", "#updateSupplier", function(e) {
            e.preventDefault();

            var method = $("input[name='_method']").attr('value');
            var id = $("#edtId").val();
            var supplier_code = $("#edtSupplierCode").val();
            var supplier_name = $("#edtSupplierName").val();
            var city = $("#edtCity").val();
            var province = $("#edtProvince").val();
            var phone = $("#edtPhone").val();
            var email = $("#edtEmail").val();
            var address = $("#edtAddress").val();
            var desc = $("#edtDesc").val();

            var url = "{{ route('supplierlist.update', ':id') }}";
            url = url.replace(':id', id);

            var fd = new FormData();
            fd.append("_method", method)
            fd.append("id", id);
            fd.append("supplier_code", supplier_code);
            fd.append("supplier_name", supplier_name);
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
                type: $('.update-supplier').attr('method'),
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
                        $('#modal-update-supplier').modal('hide');
                        table.ajax.reload();
                    } else {
                        if (responce.message.supplier_code) {
                            $('#edtSupplierCode').addClass('is-invalid');
                            $('#errorEdtSupplierCode').html(responce.message.supplier_code);
                        } else {
                            $('#edtSupplierCode').removeClass('is-invalid');
                            $('#edtSupplierCode').addClass('');
                            $('#errorEdtSupplierCode').html('');
                        }
                        if (responce.message.supplier_name) {
                            $('#edtSupplierName').addClass('is-invalid');
                            $('#errorEdtSupplierName').html(responce.message.supplier_name);
                        } else {
                            $('#edtSupplierName').removeClass('is-invalid');
                            $('#edtSupplierName').addClass('');
                            $('#errorEdtSupplierName').html('');
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

        // import supplier
        $(document).on("click", "#importsupplier", function(e) {
            e.preventDefault()

            var file = $("#filesupplier")[0].files[0];

            var fd = new FormData();
            fd.append("file", file)

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: $('.import-supplier').attr('action'),
                type: $('.import-supplier').attr('method'),
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

        // delete data supplier
        $(document).on("click", "#delete", function(e) {
            e.preventDefault();

            var id = $(this).attr("value");

            var url = "{{ route('supplierlist.destroy', ':id') }}";
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
