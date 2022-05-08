@extends('layouts.master')
@section('title', 'Daftar Bank')
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
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add-bank">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Tambah Bank
                </button>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-import-bank">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Import Bank
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table-bank" class="table" width="100%">
                    <thead>
                        <tr>
                            <th class="not-exported" width=5%>
                                <input class="checkmark select-form" type="checkbox" name="select_all" id="select_all">
                            </th>
                            <th>Bank</th>
                            <th>Keterangan</th>
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

    {{-- modals tambah Bank --}}
    <div class="modal fade" id="modal-add-bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Bank</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body text-alert">
                    Label bidang yang ditandai dengan * adalah bidang input wajib.
                </div>
                <form method="POST" action="{{ route('banklist.store') }}" class="needs-validation add-bank">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bank">Bank *</strong></label>
                                        <input type="text" class="form-control" id="bank" name="bank">
                                        <small id="errorbank" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="desc">Keterangan *</strong></label>
                                        <input type="text" class="form-control" id="desc" name="desc">
                                        <small id="errorDesc" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" id="addbank">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    {{-- modals edit Bank --}}
    <div class="modal fade" id="modal-update-bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Bank : <span id="bankTitle">test</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body text-alert">
                    Label bidang yang ditandai dengan * adalah bidang input wajib.
                </div>
                <form method="POST" class="needs-validation update-bank">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="edtId">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bank">Bank *</strong></label>
                                        <input type="text" class="form-control" id="edtbank" name="bank">
                                        <small id="errorEdtbank" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="desc">Keterangan *</strong></label>
                                        <input type="text" class="form-control" id="edtDesc" name="desc">
                                        <small id="errorEdtDesc" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" id="updatebank">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    {{-- modals import Bank --}}
    <div class="modal fade" id="modal-import-bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Bank</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body text-alert">
                    Label bidang yang ditandai dengan * adalah bidang input wajib.
                </div>
                <form method="POST" action="{{ route('banklist.import') }}" class="needs-validation import-bank"
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
                                        <label for="filebank">Unggah file CSV *</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file" class="custom-file-input" id="filebank">
                                                <label class="custom-file-label" for="filebank">Choose file</label>
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
                                        <a href="contoh_file/contoh_import_Bank.xlsx" class="btn btn-primary btn-block"><i
                                                class="fa fa-download"></i> Unduh</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" id="importbank">Simpan</button>
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
            table = $("#table-bank").DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                dom: "<'row'<'col-md-3'l><'col-md-5 'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                ajax: {
                    url: "{{ route('banklist.fetch') }}",
                    type: "GET",
                },
                columns: [{
                        data: 'select_all',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'bank'
                    },
                    {
                        data: 'desc'
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
                            let selected = $("#table-bank tbody .select-form:checked")
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
                                            url: "{{ route('banklist.destroySelected') }}",
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
                                                $('#modal-import-bank').modal(
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
                                url: `{{ route('banklist.exportPDF') }}`,
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
                .appendTo('#table-bank_wrapper .col-md-5:eq(0)');
        })

        // function select all
        $("#select_all").on('click', function() {
            var isChecked = $("#select_all").prop('checked')
            $(".select-form").prop('checked', isChecked)
        })
        // end function

        // function select one
        $("#table-bank tbody").on('click', '.select-form', function() {
            if ($(this).prop('checked') != true) {
                $("#select_all").prop('checked', false)
            }
            let selectAll = $("#table-bank tbody .select-form:checked")
            let deleteSelected = (selectAll.length > 0)
        })
        // end function

        // add bank
        $(document).on("click", "#addbank", function(e) {
            e.preventDefault();

            var bank = $("#bank").val();
            var desc = $("#desc").val();

            var fd = new FormData();
            fd.append("bank", bank);
            fd.append("desc", desc);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: $('.add-bank').attr('action'),
                type: $('.add-bank').attr('method'),
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
                        $('#modal-add-bank').modal('hide')
                        $('.add-bank')[0].reset()
                        table.ajax.reload();
                    } else {
                        if (responce.message.bank) {
                            $('#bank').addClass('is-invalid');
                            $('#errorbank').html(responce.message.bank);
                        } else {
                            $('#bank').removeClass('is-invalid');
                            $('#bank').addClass('');
                            $('#errorbank').html('');
                        }
                        if (responce.message.desc) {
                            $('#desc').addClass('is-invalid');
                            $('#errorDesc').html(responce.message.desc);
                        } else {
                            $('#desc').removeClass('is-invalid');
                            $('#desc').addClass('');
                            $('#errorDesc').html('');
                        }
                    }
                }
            })
        })

        // show data bank
        $(document).on("click", "#show", function(e) {
            e.preventDefault();

            var id = $(this).attr("value");
            var url = "{{ route('banklist.show', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: "GET",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(responce) {
                    $('#modal-update-bank').modal('show');
                    $('#bankTitle').text(responce.data.bank);
                    $('#edtId').val(responce.data.id);
                    $('#edtbank').val(responce.data.bank);
                    $('#edtDesc').val(responce.data.desc);
                }
            })
        })

        // add bank
        $(document).on("click", "#updatebank", function(e) {
            e.preventDefault();

            var method = $("input[name='_method']").attr('value');
            var id = $("#edtId").val();
            var bank = $("#edtbank").val();
            var desc = $("#edtDesc").val();

            var url = "{{ route('banklist.update', ':id') }}";
            url = url.replace(':id', id);

            var fd = new FormData();
            fd.append("_method", method)
            fd.append("id", id);
            fd.append("bank", bank);
            fd.append("desc", desc);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                type: $('.update-bank').attr('method'),
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
                        $('#modal-update-bank').modal('hide');
                        table.ajax.reload();
                    } else {
                        if (responce.message.bank) {
                            $('#edtbank').addClass('is-invalid');
                            $('#errorEdtbank').html(responce.message.bank);
                        } else {
                            $('#edtbank').removeClass('is-invalid');
                            $('#edtbank').addClass('');
                            $('#errorEdtbank').html('');
                        }
                        if (responce.message.desc) {
                            $('#edtDesc').addClass('is-invalid');
                            $('#errorEdtDesc').html(responce.message.desc);
                        } else {
                            $('#edtDesc').removeClass('is-invalid');
                            $('#edtDesc').addClass('');
                            $('#errorEdtDesc').html('');
                        }
                    }
                }
            })
        })

        // import bank
        $(document).on("click", "#importbank", function(e) {
            e.preventDefault()

            var file = $("#filebank")[0].files[0];

            var fd = new FormData();
            fd.append("file", file)

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: $('.import-bank').attr('action'),
                type: $('.import-bank').attr('method'),
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

        // delete data bank
        $(document).on("click", "#delete", function(e) {
            e.preventDefault();

            var id = $(this).attr("value");

            var url = "{{ route('banklist.destroy', ':id') }}";
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
