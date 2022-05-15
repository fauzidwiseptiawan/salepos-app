@extends('layouts.master')
@section('title', 'Pesanan Pembelian Baru')
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
                    <form method="POST" action="{{ route('brandlist.store') }}" class="needs-validation add-brand"
                        enctype="multipart/form-data">
                        <div class="card-body">
                            {{-- form pertama --}}
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="refence_no">No Transaksi</label>
                                            <input type="text" class="form-control" id="RefenceNo" name="refence_no"
                                                value="{{ $reference_no }}" readonly>
                                            <small id="errorRefenceNo" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date">Tanggal</label>
                                            <input type="text" class="form-control" id="date" name="date" readonly
                                                value="{{ date('d/m/Y H:i:s') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="desc">Supplier</label>
                                            <div class="input-group mb-3">
                                                <input type="hidden" name="supplier_id" id="supplierId">
                                                <input type="text" class="form-control showSupplier" id="supplierName"
                                                    name="supplier_name" placeholder="Select...">
                                                <div class="input-group-append showSupplier">
                                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                </div>
                                            </div>
                                            <small id="errorDesc" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Masuk Ke</label>
                                            <select value="" id="warehoseId" class="form-control select2bs4"
                                                name="warehouse_id" style="width: 100%;">
                                                <option selected disabled>Select...</option>
                                                @foreach ($warehouse as $item)
                                                    @if (old('warehouse_id') == $item->id)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Status Pembelian</label>
                                            <select value="" id="itemType" class="form-control select2bs4" name="item_type"
                                                style="width: 100%;">
                                                <option disabled selected>Select...</option>
                                                <option value="1">Menunggu Pembayaran</option>
                                                <option value="2">Menunggu Persetujuan</option>
                                                <option value="3">Disetuji</option>
                                                <option value="4">Selesai</option>
                                                <option value="5">Dibatal kan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- table item --}}
                            <div class="col-md-12">
                                <table class="table table-sm order-list" id="myTable">
                                    <thead>
                                        <tr>
                                            <th width="3%"><input class="checkmark select-form" id="select_all"
                                                    type="checkbox"></th>
                                            <th width="3%">No</th>
                                            <th width="8%">Kode</th>
                                            <th width="20%">Nama</th>
                                            <th>Jumlah</th>
                                            <th>Jml Terima</th>
                                            <th width="5%">Satuan</th>
                                            <th>Pot Rp</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th>Batch</th>
                                            <th>Tgl Exp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="hidden" name="total_qty" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="hidden" name="total_discount" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="hidden" name="total_price" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="hidden" name="item" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="hidden" name="grand_total" />
                                        <input type="hidden" name="paid_amount" value="0.00" />
                                        <input type="hidden" name="payment_status" value="1" />
                                    </div>
                                </div>
                            </div>
                            {{-- button table item --}}
                            <div class="col-md-12">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default float-left" id="showItem"><i
                                            class="fas fa-plus"></i> Item</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default float-left" id="addBrand"><i
                                            class="fas fa-pen"></i></button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default float-left" id="deleteItem"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default float-left" id="infoItem"><i
                                            class="fas fa-question-circle"></i></button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default float-left" id="updatePrice">Harga
                                        Jual</button>
                                </div>
                            </div>
                            {{-- form kedua --}}
                            <div class="col-md-12 mt-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date">Tanggal Kirim</label>
                                            <div class="input-group date" id="datesend" data-target-input="nearest">
                                                <input type="text" class="form-control form-control-sm datetimepicker-input"
                                                    data-target="#datesend" id="endDate" name="end_date"
                                                    value="{{ date('d/m/Y') }}" />
                                                <div class="input-group-append" data-target="#datesend"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="totaQty">Item</label>
                                            <input type="text" class="form-control text-right" id="totalQty"
                                                placeholder="0.00" readonly>
                                            <small id="errorTotaQty" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="recived">Terima</label>
                                            <input type="text" class="form-control text-right" id="recived"
                                                placeholder="0.00" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="subTotal">Sub Total</label>
                                            <input type="text" class="form-control text-right" id="subTotal"
                                                placeholder="0.00" readonly>
                                            <small id="errorsubTotal" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="orderDiscount">Pot Rp</label>
                                            <input type="text" class="form-control  text-right" id="orderDiscount"
                                                name="order_discount" placeholder="0.00">
                                            <small id="errorOrderDiscount" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="brand">Keterangan</label>
                                            <input type="text" class="form-control" id="brand" name="brand">
                                            <small id="errorBrand" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="grandTotal">Total Akhir</label>
                                            <input type="text"
                                                class="form-control bg-primary disabled color-palette text-right font-weight-bold"
                                                id="grandTotal" placeholder="0.00">
                                            <small id="errorGrandTotal" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- button form --}}
                            <div class="col-md-12">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-info float-left btn-block"
                                        id="addBrand">Simpan</button>
                                </div>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-warning float-left btn-block"
                                        id="addBrand">Cetak</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    <!-- /.content -->

    {{-- modals show supplier --}}
    <div class="modal fade" id="modal-show-supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cari Supplier....</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="table-supplier" class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th width="15%">Nama</th>
                                    <th>Telepon</th>
                                    <th>Alamat</th>
                                    <th width="5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    {{-- modals show item --}}
    <div class="modal fade" id="modal-show-item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cari Item....</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="table-item" class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>Kode Item</th>
                                    <th>Nama Item</th>
                                    <th>Stok</th>
                                    <th>Satuan</th>
                                    <th>Merek</th>
                                    <th>Rak</th>
                                    <th>Harga Pokok</th>
                                    <th>Harga Jual</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
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

        // function
        $('.sidebar-mini').addClass('sidebar-collapse');
        $('#dateend').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#datesend').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        var purchase_price = [];
        var item_code = [];

        var rowindex;
        var row_item_purchase;

        // show search items
        $('#showItem').on('click', function(e) {
            e.preventDefault();
            $('#modal-show-item').modal('show')
            $("#table-item").DataTable({
                destroy: true,
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('purchaseorderlist.fetchItem') }}",
                    type: "GET",
                },
                columns: [{
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
                        data: 'action',
                        searchable: false,
                        sortable: false
                    },
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
            });
        })

        // function select all
        $("#select_all").on('click', function() {
            var isChecked = $("#select_all").prop('checked')
            $(".select-form").prop('checked', isChecked)
        })
        // end function

        // function select one
        $(".order-list tbody").on('click', '.select-form', function() {
            if ($(this).prop('checked') != true) {
                $("#select_all").prop('checked', false)
            }
            let selectAll = $(".order-list tbody .select-form:checked")
            let deleteSelected = (selectAll.length > 0)
        })
        // end function

        // select items
        $(document).on('click', '#selectItem', function(e) {
            var id = $(this).attr("value");
            var url = "{{ route('purchaseorderlist.getItem', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(responce) {
                    $('#modal-show-item').modal('hide')
                    var flag = 1;
                    $(".item-code").each(function(i) {
                        if ($(this).val() == responce.data.item_code) {
                            rowindex = i;
                            var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (
                                rowindex +
                                1) + ') .qty').val()) + 1;
                            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) +
                                ') .qty').val(
                                qty);
                            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) +
                                    ') .recieved')
                                .val(qty);
                            calculateRowProductData(qty, 0, responce.data.purchase_price);
                            flag = 0;
                        }
                    });
                    if (flag) {
                        var cols = '';
                        newRow = $('<tr>');
                        cols += `<td>` +
                            `<input class="checkmark select-form" type="checkbox" value="${id}">` +
                            `</td>`;
                        cols += `<td>` + `</td>`;
                        cols += `<td>` + responce.data.item_code + `</td>`;
                        cols += `<td>` + responce.data.item_name + `</td>`;
                        cols += `<td>` +
                            `<input type="number" class="form-control form-control-sm qty" value="1" name="qty[]">` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="number" class="form-control form-control-sm" value="0" readonly>` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="text" class="form-control form-control-sm" value="${responce.data.unit.unit}">` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="number" class="form-control form-control-sm discount" value="0" name="discount[]">` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="number" class="form-control form-control-sm purchasePrice" value="${responce.data.purchase_price}" name="price[]">` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="number" class="form-control form-control-sm sub-total" readonly>` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="text" class="form-control form-control-sm">` +
                            `</td>`;
                        cols += `<td>` + `<div class="input-group date" id="dateend" data-target-input="nearest">
                            <input type="text"
                                class="form-control form-control-sm datetimepicker-input"
                                data-target="#dateend" id="endDate" name="end_date"
                                value="{{ date('d/m/Y') }}" />
                            <div class="input-group-append" data-target="#dateend"
                                data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>` + `</td>`;
                        cols +=
                            `<input type="hidden" class="item-code" name="item_code[]" value="${responce.data.item_code}"/>`;
                        cols +=
                            `<input type="hidden" class="id" name="id[]" value="${responce.data.id}"/>`;

                        newRow.append(cols)
                        $("table.order-list tbody").prepend(newRow);

                        rowindex = newRow.index();
                        // purchase_price.splice(rowindex, 0, parseFloat(responce.data.purchase_price));
                        calculateRowProductData(1, 0, responce.data.purchase_price);
                    }
                }
            })
        })

        //Change quantity
        $("#myTable").on('input', '.qty', function() {
            rowindex = $(this).closest('tr').index();
            if ($(this).val() < 1 && $(this).val() != '') {
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(1);
                alert("Quantity can't be less than 1");
            }
            calculateRowProductData($(this).val(), $('.discount').val(), $('.purchasePrice').val(),
                true)
        });

        //Change discount
        $("#myTable").on('input', '.discount', function() {
            rowindex = $(this).closest('tr').index();
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .discount').val();
            // checkQuantity($(this).val(), $(this).val(), true);
            calculateRowProductData($('.qty').val(), $(this).val(), $('.purchasePrice').val(), true)
        });

        //Change price
        $("#myTable").on('input', '.purchasePrice', function() {
            // console.log($(this).val())
            rowindex = $(this).closest('tr').index();
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .purchasePrice').val();
            calculateRowProductData($('.qty').val(), $('.discount').val(), $(this).val(), true)
        });

        //Change order discount
        $('input[name="order_discount"]').on("input", function() {
            calculateGrandTotal();
        });

        // remove row items
        $(document).on('click', '#deleteItem', function() {
            let selected = $("#myTable tbody .select-form:checked")
            let id = []
            // looping row selected
            $.each(selected, function(index, responce) {
                id.push(responce.value)
                if ($('.select-form:checked').length > 0) {
                    $(this).closest('tr').remove();
                    calculateTotal();
                } else {
                    alert('test')
                }
            })
        })

        // show search supplier
        $('.showSupplier').on('click', function(e) {
            e.preventDefault();
            $('#modal-show-supplier').modal('show')
            $("#table-supplier").DataTable({
                destroy: true,
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('purchaseorderlist.fetchSupplier') }}",
                    type: "GET",
                },
                columns: [{
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
            });
        })

        // select supplier
        $(document).on('click', '#selectSupplier', function(e) {
            e.preventDefault();

            var id = $(this).attr("value");
            var url = "{{ route('purchaseorderlist.getSupplier', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: "GET",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(responce) {
                    console.log(responce);
                    $('#supplierId').val(responce.data.id);
                    $('#supplierName').val(responce.data.supplier_name);
                    $('#modal-show-supplier').modal('hide')
                }
            })
        })

        function calculateRowProductData(quantity, discount, price) {
            var net_unit_cost = price - discount;
            var sub_total = net_unit_cost * quantity;
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sub-total').val(sub_total);
            calculateTotal();
        }

        function calculateTotal() {
            //Sum of quantity
            var total_qty = 0;
            $(".qty").each(function() {

                if ($(this).val() == '') {
                    total_qty += 0;
                } else {
                    total_qty += parseFloat($(this).val());
                }
            });
            $("#totalQty").val(total_qty.toFixed(2));
            $('input[name="total_qty"]').val(total_qty);

            //Sum of discount
            var total_discount = 0;
            $(".discount").each(function() {
                total_discount += parseFloat($(this).val());
            });
            $("#total-discount").val(total_discount);
            $('input[name="total_discount"]').val(total_discount);

            //Sum of subtotal
            var subtotal = 0;
            $(".sub-total").each(function() {
                subtotal += parseFloat($(this).val());
            });
            $("#subTotal").val(format_uang(subtotal));
            $('input[name="total_price"]').val(subtotal);

            calculateGrandTotal()
        }

        function calculateGrandTotal() {

            var item = $('table.order-list tbody tr:last').index();

            var total_qty = parseFloat($('#totalQty').val());
            var subtotal = parseFloat($('input[name="total_price"]').val());
            var order_discount = parseFloat($('input[name="order_discount"]').val());

            if (!order_discount)
                order_discount = 0.00;

            item = ++item + '(' + total_qty + ')';
            var grand_total = subtotal - order_discount;

            $('#item').val(item);
            $('input[name="item"]').val($('table.order-list tbody tr:last').index() + 1);
            $('#subTotal').val(format_uang(subtotal));
            $('#order_discount').val(order_discount);
            $('#grandTotal').val(format_uang(grand_total));
            $('input[name="grand_total"]').val(grand_total);
        }
    </script>
@endpush
