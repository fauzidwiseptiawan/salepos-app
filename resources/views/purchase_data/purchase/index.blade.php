@extends('layouts.master')
@section('title', 'Daftar Pesanan Pembelian')
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
                <a href="{{ route('purchaselist.create') }}" class="btn btn-info">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Tambah Pesanan
                </a>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-import-purchase">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Import Pesanan
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table-purchase" class="table" width="100%">
                    <thead>
                        <tr>
                            <th class="not-exported" width=5%>
                                <input class="checkmark select-form" type="checkbox" name="select_all" id="select_all">
                            </th>
                            <th>No Transaksi</th>
                            <th>Tanggal</th>
                            <th>Dept/Gudang</th>
                            <th>Kode Supplier</th>
                            <th>Supplier</th>
                            <th>Jumlah Pesan</th>
                            <th>Jumlah Terima</th>
                            <th>Total</th>
                            <th class="not-exported" width="10%">Aksi</th>
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

    {{-- modals import satuan --}}
    <div class="modal fade" id="modal-import-purchase" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body text-alert">
                    Label bidang yang ditandai dengan * adalah bidang input wajib.
                </div>
                <form method="POST" action="{{ route('purchaselist.import') }}" class="needs-validation import-purchase"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="callout callout-info">
                            <p>Urutan kolom yang benar adalah (purchase*, desc*, image [nama file]) dan Anda harus mengikuti
                                ini.!</p>
                            <p>Untuk menampilkan Gambar itu harus disimpan di direktori public/storage/purchase-image.!</p>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="filepurchase">Unggah file CSV *</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file" class="custom-file-input" id="filepurchase">
                                                <label class="custom-file-label" for="filepurchase">Choose file</label>
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
                                        <a href="contoh_file/contoh_import_Pembelian.xlsx"
                                            class="btn btn-primary btn-block"><i class="fa fa-download"></i> Unduh</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" id="importpurchase">Simpan</button>
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
        $('.sidebar-mini').addClass('sidebar-collapse')
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
            table = $("#table-purchase").DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                dom: "<'row'<'col-md-3'l><'col-md-5 'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                ajax: {
                    url: "{{ route('purchaselist.fetch') }}",
                    type: "GET",
                },
                columns: [{
                        data: 'select_all',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'reference_no'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'warehouse'
                    },
                    {
                        data: 'kode_supplier'
                    },
                    {
                        data: 'supplier'
                    },
                    {
                        data: 'total_qty'
                    },
                    {
                        data: 'total_recieved'
                    },
                    {
                        data: 'grand_total'
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
                            let selected = $("#table-purchase tbody .select-form:checked")
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
                                            url: "{{ route('purchaselist.destroySelected') }}",
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
                                                table.ajax.reload();
                                            }
                                        })
                                    }
                                })
                            } else {
                                Toast.fire({
                                    icon: 'warning',
                                    title: 'Oops..!',
                                    text: 'Tidak ada Pembelian yang dipilih!'
                                });
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i title="eksport ke pdf" class="far fa-file-pdf"></i>',
                        action: function(e, dt, node, config) {
                            var data = '';
                            $.ajax({
                                url: `{{ route('purchaselist.exportPDF') }}`,
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
                        text: '<i title="export to csv" class="far fa-file-alt"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 0 && (data.indexOf('<img src=') !== -1)) {
                                        var regex = /<img.*?src=['"](.*?)['"]/;
                                        data = regex.exec(data)[1];
                                    }
                                    return data;
                                }
                            }
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
                .appendTo('#table-purchase_wrapper .col-md-5:eq(0)');
        })

        // costume file input
        $('.custom-file-input').on('change', function() {
            let filename = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(filename);
        });

        // function select all
        $("#select_all").on('click', function() {
            var isChecked = $("#select_all").prop('checked')
            $(".select-form").prop('checked', isChecked)
        })
        // end function

        // function select one
        $("#table-purchase tbody").on('click', '.select-form', function() {
            if ($(this).prop('checked') != true) {
                $("#select_all").prop('checked', false)
            }
            let selectAll = $("#table-purchase tbody .select-form:checked")
            let deleteSelected = (selectAll.length > 0)
        })
        // end function

        // import purchase
        $(document).on("click", "#importpurchase", function(e) {
            e.preventDefault()

            var file = $("#filepurchase")[0].files[0];

            var fd = new FormData();
            fd.append("file", file)

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: $('.import-purchase').attr('action'),
                type: $('.import-purchase').attr('method'),
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
                        $('#modal-import-purchase').modal(
                            'hide');
                        table.ajax.reload();
                    }
                }
            })
        })

        // delete data purchase
        $(document).on("click", "#delete", function(e) {
            e.preventDefault();

            var id = $(this).attr("value");
            var url = "{{ route('purchaselist.destroy', ':id') }}";
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
