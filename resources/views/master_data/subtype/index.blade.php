@extends('layouts.master')
@section('title', 'Daftar Sub Jenis')
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
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add-subType">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Tambah Sub Jenis
                </button>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-import-subtype">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Import Sub Jenis
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table-subType" class="table" width="100%">
                    <thead>
                        <tr>
                            <th class="not-exported" width=5%>
                                <input class="checkmark select-form" type="checkbox" name="select_all" id="select_all">
                            </th>
                            <th>Sub Jenis</th>
                            <th>Keterangan</th>
                            <th>Jenis</th>
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

    {{-- modals tambah sub jenis --}}
    <div class="modal fade" id="modal-add-subType" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Sub Jenis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body text-alert">
                    Label bidang yang ditandai dengan * adalah bidang input wajib.
                </div>
                <form method="POST" action="{{ route('subtypelist.store') }}" class="needs-validation add-subType">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subType">Sub Jenis *</strong></label>
                                        <input type="text" class="form-control" id="subType" name="subtype">
                                        <small id="errorSubType" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="typeId">Jenis</label>
                                        <select class="form-control" id="typeId" name="type_id">
                                            <option value="" selected>Pilih...</option>
                                            @foreach ($type as $item)
                                                @if (old('type_id') == $item->id)
                                                    <option value="{{ $item->id }}">{{ $item->type }}</option>
                                                @else
                                                    <option value="{{ $item->id }}">{{ $item->type }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <small id="errorTypeId" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
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
                        <button type="submit" class="btn btn-info" id="addSubType">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    {{-- modals edit jenis --}}
    <div class="modal fade" id="modal-update-subType" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Jenis : <span id="subTypeTitle"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body text-alert">
                    Label bidang yang ditandai dengan * adalah bidang input wajib.
                </div>
                <form method="POST" class="needs-validation update-subType">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="edtId">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Jenis *</strong></label>
                                        <input type="text" class="form-control" id="edtSubType" name="sub_type">
                                        <small id="errorEdtSubType" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Jenis</label>
                                        <select value="" id="edtTypeId" class="form-control" name="type_id">
                                            <option selected disabled>Pilih...</option>
                                            @foreach ($type as $item)
                                                @if (old('type_id') == $item->id)
                                                    <option value="{{ $item->id }}">{{ $item->type }}
                                                    </option>
                                                @else
                                                    <option value="{{ $item->id }}">{{ $item->type }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
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
                        <button type="submit" class="btn btn-info" id="updateSubType">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    {{-- modals import sub jenis --}}
    <div class="modal fade" id="modal-import-subType" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Sub Jenis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body text-alert">
                    Label bidang yang ditandai dengan * adalah bidang input wajib.
                </div>
                <form method="POST" action="{{ route('subtypelist.import') }}" class="needs-validation import-subType"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="callout callout-info">
                            <p>Urutan kolom yang benar adalah (subtype*, desc*, type*) harus mengikuti ini.!</p>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="filetype">Unggah file CSV *</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file" class="custom-file-input" id="filetype">
                                                <label class="custom-file-label" for="filetype">Choose file</label>
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
                                        <a href="contoh_file/contoh_import_subjenis.xlsx"
                                            class="btn btn-primary btn-block"><i class="fa fa-download"></i> Unduh</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" id="importSubType">Simpan</button>
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
            table = $("#table-subType").DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                dom: "<'row'<'col-md-3'l><'col-md-5 'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                ajax: {
                    url: "{{ route('subtypelist.fetch') }}",
                    type: "GET",
                },
                columns: [{
                        data: 'select_all',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'subtype'
                    },
                    {
                        data: 'desc'
                    },
                    {
                        data: 'type'
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
                            let selected = $("#table-subType tbody .select-form:checked")
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
                                            url: "{{ route('subtypelist.destroySelected') }}",
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
                                                $('#modal-import-subType')
                                                    .modal('hide');
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
                                url: `{{ route('subtypelist.exportPDF') }}`,
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
                .appendTo('#table-subType_wrapper .col-md-5:eq(0)');
        })

        // function select all
        $("#select_all").on('click', function() {
            var isChecked = $("#select_all").prop('checked')
            $(".select-form").prop('checked', isChecked)
        })
        // end function

        // function select one
        $("#table-subType tbody").on('click', '.select-form', function() {
            if ($(this).prop('checked') != true) {
                $("#select_all").prop('checked', false)
            }
            let selectAll = $("#table-subType tbody .select-form:checked")
            let deleteSelected = (selectAll.length > 0)
        })
        // end function

        // add type
        $(document).on("click", "#addSubType", function(e) {
            e.preventDefault();

            var subtype = $("#subType").val();
            var desc = $("#desc").val();
            var type = $("#typeId").val();

            var fd = new FormData();
            fd.append("subtype", subtype);
            fd.append("type_id", type);
            fd.append("desc", desc);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: $('.add-subType').attr('action'),
                type: $('.add-subType').attr('method'),
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
                        $('#modal-add-subType').modal('hide')
                        $('.add-subType')[0].reset()
                        table.ajax.reload();
                    } else {
                        if (responce.message.subtype) {
                            $('#subType').addClass('is-invalid');
                            $('#errorSubType').html(responce.message.subtype);
                        } else {
                            $('#subType').removeClass('is-invalid');
                            $('#subType').addClass('');
                            $('#errorSubType').html('');
                        }
                        if (responce.message.desc) {
                            $('#desc').addClass('is-invalid');
                            $('#errorDesc').html(responce.message.desc);
                        } else {
                            $('#desc').removeClass('is-invalid');
                            $('#desc').addClass('');
                            $('#errorDesc').html('');
                        }
                        if (responce.message.type_id) {
                            $('#typeId').addClass('is-invalid');
                            $('#errorTypeId').html(responce.message.type_id);
                        } else {
                            $('#typeId').removeClass('is-invalid');
                            $('#typeId').addClass('');
                            $('#errorTypeId').html('');
                        }
                    }
                }
            })
        })

        // show data type
        $(document).on("click", "#show", function(e) {
            e.preventDefault();

            var id = $(this).attr("value");
            var url = "{{ route('subtypelist.show', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: "GET",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(responce) {
                    $('#modal-update-subType').modal('show');
                    $('#subTypeTitle').text(responce.data.type);
                    $('#edtId').val(responce.data.id);
                    $('#edtSubType').val(responce.data.subtype);
                    $('#edtDesc').val(responce.data.desc);
                    $('#edtTypeId').val(responce.data.type_id);
                }
            })
        })

        // add type
        $(document).on("click", "#updateSubType", function(e) {
            e.preventDefault();

            var method = $("input[name='_method']").attr('value');
            var id = $("#edtId").val();
            var subtype = $("#edtSubType").val();
            var desc = $("#edtDesc").val();
            var type = $("#edtTypeId").val();

            var url = "{{ route('subtypelist.update', ':id') }}";
            url = url.replace(':id', id);

            var fd = new FormData();
            fd.append("_method", method)
            fd.append("id", id);
            fd.append("subtype", subtype);
            fd.append("type_id", type);
            fd.append("desc", desc);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                type: $('.update-subType').attr('method'),
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
                        $('#modal-update-subType').modal('hide');
                        table.ajax.reload();
                    } else {
                        if (responce.message.subtype) {
                            $('#edtSubType').addClass('is-invalid');
                            $('#errorEdtSubType').html(responce.message.subtype);
                        } else {
                            $('#edtSubType').removeClass('is-invalid');
                            $('#edtSubType').addClass('');
                            $('#errorEdtSubType').html('');
                        }
                        if (responce.message.desc) {
                            $('#edtDesc').addClass('is-invalid');
                            $('#errorEdtDesc').html(responce.message.desc);
                        } else {
                            $('#edtDesc').removeClass('is-invalid');
                            $('#edtDesc').addClass('');
                            $('#errorEdtDesc').html('');
                        }
                        if (responce.message.type) {
                            $('#edtType').addClass('is-invalid');
                            $('#errorEdtType').html(responce.message.type);
                        } else {
                            $('#edtType').removeClass('is-invalid');
                            $('#edtType').addClass('');
                            $('#errorEdtType').html('');
                        }
                    }
                }
            })
        })

        // import type
        $(document).on("click", "#importType", function(e) {
            e.preventDefault()

            var file = $("#filetype")[0].files[0];

            var fd = new FormData();
            fd.append("file", file)

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: $('.import-type').attr('action'),
                type: $('.import-type').attr('method'),
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

        // delete data type
        $(document).on("click", "#delete", function(e) {
            e.preventDefault();

            var id = $(this).attr("value");

            var url = "{{ route('subtypelist.destroy', ':id') }}";
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
