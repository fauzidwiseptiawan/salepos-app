@extends('layouts.master')
@section('title', 'Daftar Item')
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
                <a href="{{ route('itemlist.create') }}" class="btn btn-info">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Tambah Item
                </a>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-import-item">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Import Item
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table-item" class="table" width="100%">
                    <thead>
                        <tr>
                            <th class="not-exported" width=5%>
                                <input class="checkmark select-form" type="checkbox" name="select_all" id="select_all">
                            </th>
                            <th>Kode Item</th>
                            <th>Nama Item</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                            <th>Jenis</th>
                            <th>Merek</th>
                            <th>Rak</th>
                            <th>Harga Pokok</th>
                            <th>Harga Jual</th>
                            <th>Supplier</th>
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

    {{-- modals detail detail item --}}
    <div class="modal fade" id="modal-detail-item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ItemCode">Rincian Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="text-bold" width="30%">Kode Item</td>
                                            <td width="1%">:</td>
                                            <td><span id="itemCode"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold" width="30%">Barcode</td>
                                            <td width="1%">:</td>
                                            <td><span id="barcode"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold" width="30%">Nama Item</td>
                                            <td width="1%">:</td>
                                            <td><span id="itemName"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold" width="30%">Stok</td>
                                            <td width="1%">:</td>
                                            <td><span id="stock"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold" width="30%">Harga Beli</td>
                                            <td width="1%">:</td>
                                            <td><span id="purchasePrice"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold" width="30%">Harga Jual</td>
                                            <td width="1%">:</td>
                                            <td><span id="sellingPrice"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="text-bold" width="30%">Jenis</td>
                                            <td width="1%">:</td>
                                            <td><span id="type"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold" width="30%">Sub Jenis</td>
                                            <td width="1%">:</td>
                                            <td><span id="subType"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold" width="30%">Merek</td>
                                            <td width="1%">:</td>
                                            <td><span id="brand"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold" width="30%">Satuan</td>
                                            <td width="1%">:</td>
                                            <td><span id="unit"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold" width="30%">Supplier</td>
                                            <td width="1%">:</td>
                                            <td><span id="supplier"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold" width="30%">Rak</td>
                                            <td width="1%">:</td>
                                            <td><span id="rack"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold" width="40%">Stok Minimum</td>
                                            <td width="1%">:</td>
                                            <td><span id="stockMinimum"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="text-bold" width="40%">Keterangan</td>
                                            <td width="1%">:</td>
                                            <td><span id="desc"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold" width="30%">Harga Promosi</td>
                                            <td width="1%">:</td>
                                            <td><span id="promotionPrice"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold" width="30%">Tanggal Mulai</td>
                                            <td width="1%">:</td>
                                            <td><span id="startDate"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold" width="30%">Tanggal Selesai</td>
                                            <td width="1%">:</td>
                                            <td><span id="endDate"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <img src="{{ asset('template/dist/img/default.png') }}" class="rounded mx-auto d-block"
                                    width="50%" alt="{{ asset('template/dist/img/default.png') }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <h3 class="card-title">Kuantitas Gudang</h3>
                    </div>
                    <div class="card-body">
                        <table class="table" id="example2" width="100%">
                            <thead class="table-active">
                                <tr>
                                    <th>Gudang</th>
                                    <th>Nomor Batch</th>
                                    <th>Tanggal Kadaluarsa</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Gudang</td>
                                    <td>001</td>
                                    <td>11/05/2023</td>
                                    <td>10</td>
                                </tr>
                                <tr>
                                    <td>Toko</td>
                                    <td>001</td>
                                    <td>12/05/2022</td>
                                    <td>20</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    {{-- modals import satuan --}}
    <div class="modal fade" id="modal-import-item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body text-alert">
                    Label bidang yang ditandai dengan * adalah bidang input wajib.
                </div>
                <form method="POST" action="{{ route('itemlist.import') }}" class="needs-validation import-item"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="callout callout-info">
                            <p>Urutan kolom yang benar adalah (item*, desc*, image [nama file]) dan Anda harus mengikuti
                                ini.!</p>
                            <p>Untuk menampilkan Gambar itu harus disimpan di direktori public/storage/item-image.!</p>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fileitem">Unggah file CSV *</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file" class="custom-file-input" id="fileitem">
                                                <label class="custom-file-label" for="fileitem">Choose file</label>
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
                                        <a href="contoh_file/contoh_import_item.xlsx" class="btn btn-primary btn-block"><i
                                                class="fa fa-download"></i> Unduh</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" id="importitem">Simpan</button>
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
            table = $("#table-item").DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                dom: "<'row'<'col-md-3'l><'col-md-5 'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                ajax: {
                    url: "{{ route('itemlist.fetch') }}",
                    type: "GET",
                },
                createdRow: function(row, data, dataIndex) {
                    $(row).addClass('item-link');
                    $(row).attr('data-item', data['id']);
                },
                columns: [{
                        data: 'select_all',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'item_code'
                    },
                    {
                        data: 'item_name'
                    },
                    {
                        data: 'stock'
                    },
                    {
                        data: 'unit'
                    },
                    {
                        data: 'type'
                    },
                    {
                        data: 'brand'
                    },
                    {
                        data: 'rack'
                    },
                    {
                        data: 'purchase_price'
                    },
                    {
                        data: 'selling_price'
                    },
                    {
                        data: 'supplier'
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
                            let selected = $("#table-item tbody .select-form:checked")
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
                                            url: "{{ route('itemlist.destroySelected') }}",
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
                                    text: 'Tidak ada item yang dipilih!'
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
                                url: `{{ route('itemlist.exportPDF') }}`,
                                type: "GET",
                                data: data,
                                success: function(responce) {
                                    console.log(responce)
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
                .appendTo('#table-item_wrapper .col-md-5:eq(0)');
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
        $("#table-item tbody").on('click', '.select-form', function() {
            if ($(this).prop('checked') != true) {
                $("#select_all").prop('checked', false)
            }
            let selectAll = $("#table-item tbody .select-form:checked")
            let deleteSelected = (selectAll.length > 0)
        })
        // end function

        // detail item
        $(document).on("click", "tr.item-link td:not(:first-child, :last-child)", function() {
            var id = $(this).parent().data('item');
            var url = "{{ route('itemlist.details', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: "GET",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(responce) {
                    $('#modal-detail-item').modal('show');
                    console.log(responce);
                    // $('#modal-update-type').modal('show');
                    $('#itemCode').text(responce.data[0].item_code);
                    $('#barcode').text(responce.data[0].barcode);
                    $('#itemName').text(responce.data[0].item_name);
                    if (responce.data[0].stock == null) {
                        $('#stock').text('0');
                    } else {
                        $('#stock').text(responce.data[0].stock);
                    }
                    $('#purchasePrice').text(responce.data[0].purchase_price);
                    $('#sellingPrice').text(responce.data[0].selling_price);
                    $('#rack').text(responce.data[0].rack);
                    $('#stockMinimum').text(responce.data[0].minimum_stock);
                    $('#brand').text(responce.data[0].brand.brand);
                    $('#type').text(responce.data[0].type.type);
                    $('#unit').text(responce.data[0].unit.unit);
                    $('#subType').text(responce.data[0].subtype.subtype);
                    $('#supplier').text(responce.data[0].supplier.supplier_name);
                    if (responce.data[0].desc == null) {
                        $('#desc').text('-');
                    } else {
                        $('#desc').text(responce.data[0].desc);
                    }
                    if (responce.data[0].promotion_price && responce.data[0].start_date && responce
                        .data[0]
                        .end_date != null) {
                        $('#promotionPrice').text(responce.data[0].promotion_price);
                        $('#startDate').text(moment(new Date(responce.data[0].start_date)).format(
                            "DD/MM/YYYY"));
                        $('#endDate').text(moment(new Date(responce.data[0].end_date)).format(
                            "DD/MM/YYYY"));
                    } else {
                        $('#promotionPrice').text('-');
                        $('#startDate').text('-');
                        $('#endDate').text('-');
                    }
                }
            })
        });

        // import item
        $(document).on("click", "#importitem", function(e) {
            e.preventDefault()

            var file = $("#fileitem")[0].files[0];

            var fd = new FormData();
            fd.append("file", file)

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: $('.import-item').attr('action'),
                type: $('.import-item').attr('method'),
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
                        $('#modal-import-item').modal(
                            'hide');
                        table.ajax.reload();
                    }
                }
            })
        })

        // delete data item
        $(document).on("click", "#delete", function(e) {
            e.preventDefault();

            var id = $(this).attr("value");
            var url = "{{ route('itemlist.destroy', ':id') }}";
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

        // detail table gudang
        $('#example2').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    </script>
@endpush
