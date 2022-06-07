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
                    <form method="POST" action="{{ route('purchaselist.store') }}"
                        class="needs-validation add-purchase-order" enctype="multipart/form-data">
                        <div class="card-body">
                            {{-- form pertama --}}
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="reference_no">No Transaksi</label>
                                            <input type="text" class="form-control" id="ReferenceNo" name="reference_no"
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
                                            <small id="errorSupplierId" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Masuk Ke</label>
                                            <select value="" id="warehouseId" class="form-control select2bs4"
                                                name="warehouse_id" style="width: 100%;">
                                                <option></option>
                                                @foreach ($warehouse as $item)
                                                    @if (old('warehouse_id') == $item->id)
                                                        <option value="{{ $item->id }}">{{ $item->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <small id="errorWarehouseId" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="order">Pesanan</label>
                                            <div class="input-group mb-3">
                                                <input type="hidden" name="order_purchase_id" id="orderPurchaseId">
                                                <input type="text" class="form-control showOrder" id="referenceNoOrder"
                                                    name="reference_no" placeholder="Select...">
                                                <div class="input-group-append showOrder">
                                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                </div>
                                            </div>
                                            <small id="errorOrderPurchaseId" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- table item --}}
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm order-list" id="myTable">
                                        <thead>
                                            <tr>
                                                <th width="3%"><input class="checkmark select-form" id="select_all"
                                                        type="checkbox"></th>
                                                <th width="3%">No</th>
                                                <th width="8%">Kode</th>
                                                <th width="20%">Nama</th>
                                                <th>Jml Pesan</th>
                                                <th>Jumlah</th>
                                                <th width="5%">Satuan</th>
                                                <th>Pot Rp</th>
                                                <th>Harga Pokok</th>
                                                <th>Total</th>
                                                <th>Batch</th>
                                                <th>Tgl Exp</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listOrder">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="hidden" name="total_qty" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="hidden" name="total_recieved" />
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
                                        <input type="hidden" name="total_item" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="hidden" name="grand_total" />
                                        <input type="hidden" name="paid_amount" value="0.00" />
                                        <input type="hidden" name="purchase_status" value="4" />
                                        <input type="hidden" name="payment_status" value="2" />
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
                                    <button type="button" class="btn btn-default float-left" id="showPurchasePirce">Harga
                                        Jual</button>
                                </div>
                            </div>
                            {{-- form kedua --}}
                            <div class="col-md-12 mt-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date">Jatuh Tempo</label>
                                            {{-- <input type="date" name="send_date" id="sendDate"> --}}
                                            <div class="input-group date" id="senddate" data-target-input="nearest">
                                                <input type="text" class="form-control form-control-sm datetimepicker-input"
                                                    data-target="#senddate" id="sendDate" name="send_date"
                                                    value="{{ date('d/m/Y', strtotime(' + 14 days')) }}" />
                                                <div class="input-group-append" data-target="#senddate"
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
                                            <input type="text" class="form-control text-right" id="totalRecieved"
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
                                            <label for="desc">Keterangan</label>
                                            <input type="text" class="form-control" id="desc" name="desc">
                                            <small id="errorDesc" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="grandTotal">Total Akhir</label>
                                            <input type="text"
                                                class="form-control bg-primary disabled color-palette text-right font-weight-bold"
                                                style="font-size: 25px" id="grandTotal" value="0.00" readonly>
                                            <small id="errorGrandTotal" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- button form --}}
                            <div class="col-md-12">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-info float-left btn-block"
                                        id="savePurchase">Simpan</button>
                                </div>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-warning float-left btn-block"
                                        id="payment">Bayar</button>
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

    {{-- modals show order --}}
    <div class="modal fade" id="modal-show-order" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cari Pesanan....</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="table-order" class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>No Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Tanggal Kirim</th>
                                    <th>Dept/Gudang</th>
                                    <th>Nama</th>
                                    <th>Jumlah Pesanan</th>
                                    <th>Jumlah Terima</th>
                                    <th>Total</th>
                                    <th>Total</th>
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

    {{-- modals update price --}}
    <div class="modal fade" id="modal-show-update-price" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Harga Jual</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body text-alert">
                    Note : Harga akan disimpan pada master setelah klik simpan.
                </div>
                <form method="POST" class="needs-validation update-price">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="text" id="id">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="itemCode">Kode Item</label>
                                    <input type="text" class="form-control" id="itemCode" name="item_code" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="unit">Satuan</label>
                                    <input type="text" class="form-control" id="unit" name="unit" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="sellingPrice">Harga Jual</label>
                                    <input type="text" class="form-control" id="selling" name="selling_price"
                                        onkeyup="format_uang(this)">
                                    <small id="errorSellingPrice" class="form-text text-muted"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" id="updatePrice">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    {{-- modals payment --}}
    <div class="modal fade" id="modal-show-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" class="needs-validation payment">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="paymentTotal" class="col-sm-2 col-form-label">Total</label>
                            <div class="col-sm-10">
                                <input type="number" name="payment_total" class="form-control" id="paymentTotal">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="payCash" class="col-sm-2 col-form-label">Bayar Tunai</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="pay_cash" id="payCash">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="paymentTotalCash" class="col-sm-2 col-form-label">Total</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="payment_total_cash" id="paymentTotalCash"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="remainder" class="col-sm-2 col-form-label">Sisa</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="remainder" id="remainder" readonly>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" id="savePurchase" class="btn btn-info">Simpan</button>
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
        // function
        $('.sidebar-mini').addClass('sidebar-collapse');
        // show sweetalert
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        // function pageRedirect
        function pageRedirect() {
            window.location = "{{ route('purchaselist.index') }}";
        }

        // format date
        $('body').on('focus', ".datetimes", function() {
            $(this).datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                todayHighlight: true
            });
        });
        $('#senddate').datetimepicker({
            format: 'DD/MM/YYYY',
        });

        // format select option
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            placeholder: "Select...",
            allowClear: false
        })

        // temporary array
        var purchase_price = [];
        var item_code = [];
        var rowindex;
        let number = 1

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
                    url: "{{ route('purchaselist.fetchItem') }}",
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

        // function select one
        $(".order-list tbody").on('click', '.select-form', function() {
            if ($(this).prop('checked') != true) {
                $("#select_all").prop('checked', false)
            }
            let selectAll = $(".order-list tbody .select-form:checked")
            let deleteSelected = (selectAll.length > 0)
        })

        // select items
        $(document).on('click', '#selectItem', function(e) {
            var id = $(this).attr("value");
            var url = "{{ route('purchaselist.getItem', ':id') }}";
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
                                rowindex + 1) + ') .qty').val()) + 1;
                            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) +
                                ') .qty').val(qty);
                            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) +
                                ') .recieved').val(qty);
                            calculateRowitemData(qty, 0, responce.data.purchase_price);
                            flag = 0;
                        }
                    });
                    if (flag) {
                        var cols = '';
                        number = number + 1;
                        newRow = $('<tr>');
                        cols += `<td>` +
                            `<input class="checkmark select-form" type="checkbox" value="${id}">` +
                            `</td>`;
                        cols += `<td>` + number + `</td>`;
                        cols += `<td>` + responce.data.item_code + `</td>`;
                        cols += `<td>` + responce.data.item_name + `</td>`;
                        cols += `<td>` +
                            `<input type="number" class="form-control form-control-sm qty" value="0" name="qty[]" readonly>` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="number" class="form-control form-control-sm recieved" value="1" name="recieved[]">` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="text" class="form-control form-control-sm" value="${responce.data.unit.unit}"readonly>` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="number" class="form-control form-control-sm discount" value="0" name="discount[]">` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="number" class="form-control form-control-sm purchasePrice" value="${responce.data.purchase_price}" name="purchase_price[]">` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="number" class="form-control form-control-sm sub-total" name="subtotal[]" readonly>` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="text" class="form-control form-control-sm batch-no" name="batch_no[]">` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="text" class="form-control form-control-sm datetimes" name="expired_date[]" value="{{ date('d/m/Y') }}"/>` +
                            `</td>`;
                        cols +=
                            `<input type="hidden" class="item-code" name="item_code[]" value="${responce.data.item_code}"/>`;
                        cols +=
                            `<input type="hidden" class="item-id" name="item_id[]" value="${responce.data.id}"/>`;
                        newRow.append(cols)
                        $("table.order-list tbody").prepend(newRow);
                        rowindex = newRow.index();
                        calculateRowitemData(1, 0, responce.data.purchase_price);
                    }
                }
            })
        })

        //Change recieved
        $("#myTable").on('input', '.recieved', function() {
            rowindex = $(this).closest('tr').index();
            var purchasePrice = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .purchasePrice')
                .val();
            var discount = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .discount').val();
            if ($(this).val() < 1 && $(this).val() != '') {
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .recieved').val(1);
                alert("Quantity can't be less than 1");
            }
            calculateRowitemData($(this).val(), discount, purchasePrice)
        });

        //Change discount
        $("#myTable").on('input', '.discount', function() {
            rowindex = $(this).closest('tr').index();
            var purchasePrice = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .purchasePrice')
                .val();
            var quantity = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .recieved').val();
            if (parseFloat($(this).val()) > parseFloat(purchasePrice)) {
                Toast.fire({
                    icon: 'error',
                    title: 'Oppss..!',
                    text: 'Diskon lebih besar dari harga pokok!'
                });
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .discount').val(0);
            }
            calculateRowitemData(quantity, $(this).val(), purchasePrice)
        });

        // Change price
        $("#myTable").on('change', '.purchasePrice', function() {
            rowindex = $(this).closest('tr').index();
            var id = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .select-form').val()
            var quantity = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .recieved').val();
            var discount = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .discount').val()
            var url = "{{ route('purchaseorderlist.changePurchasePrice', ':id') }}";
            url = url.replace(':id', id);
            var fd = new FormData();
            fd.append("purchase_price", $(this).val())
            if ($(this).val() == $(this).val()) {
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .purchasePrice').val();
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Harga Pokok akan di ubah pada master data ? Harga Pokok akan disimpan setelah klik tombol Simpan",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: url,
                            type: "POST",
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
                                }
                            }
                        })
                    }
                })
            }
            calculateRowitemData(quantity, discount, $(this).val())
        });

        //Change order discount
        $('input[name="order_discount"]').on("input", function() {
            calculateGrandTotal();
        });

        // store purchase order
        $(document).on('click', '#savePurchase', function(e) {
            e.preventDefault();

            var items = [];
            var referenceNo = $('#ReferenceNo').val();
            var grandTotal = $('input[name="grand_total"]').val();
            var totalDiscount = $('input[name="total_discount"]').val();
            var totalQty = $('input[name="total_qty"]').val();
            var totalRecieved = $('input[name="total_recieved"]').val();
            var totalItem = $('input[name="total_item"]').val();
            var orderDiscount = $('#orderDiscount').val();
            var orderPurchase = $('#orderPurchaseId').val();
            var supplier = $('#supplierId').val();
            var sendDate = $('#sendDate').val();
            var totalPrice = $('#subTotal').val();
            var warehouse = $('#warehouseId').val();
            var purchaseStatus = $('input[name="purchase_status"]').val();
            var paymentStatus = $('input[name="payment_status"]').val();
            var desc = $('#desc').val();
            var rownumber = $('table.order-list tbody tr:last').index();
            var fd = new FormData();
            // looping row selected
            $('input[name="item_id[]"]').each(function() {
                items.push(fd.append("item_id[]", $(this).val()));
            })
            $('input[name="qty[]"]').each(function() {
                items.push(fd.append("qty[]", $(this).val()));
            })
            $('input[name="discount[]"]').each(function() {
                items.push(fd.append("discount[]", $(this).val()));
            })
            $('input[name="expired_date[]"]').each(function() {
                items.push(fd.append("expired_date[]", $(this).val()));
            })
            $('input[name="batch_no[]"]').each(function() {
                items.push(fd.append("batch_no[]", $(this).val()));
            })
            $('input[name="recieved[]"]').each(function() {
                items.push(fd.append("recieved[]", $(this).val()));
            })
            $('input[name="purchase_price[]"]').each(function() {
                items.push(fd.append("purchase_price[]", $(this).val()));
            })
            $('input[name="subtotal[]"]').each(function() {
                items.push(fd.append("subtotal[]", $(this).val()));
            })
            fd.append("reference_no", referenceNo);
            fd.append("supplier_id", supplier);
            fd.append("send_date", sendDate);
            fd.append("warehouse_id", warehouse);
            fd.append("order_discount", orderDiscount);
            fd.append("grand_total", grandTotal);
            fd.append("total_discount", totalDiscount);
            fd.append("total_qty", totalQty);
            fd.append("total_price", parseFloat(totalPrice.replaceAll('.', '')));
            fd.append("total_recieved", totalRecieved);
            fd.append("total_item", totalItem);
            fd.append("order_purchase_id", orderPurchase);
            fd.append("purchase_status", purchaseStatus);
            fd.append("payment_status", paymentStatus);
            fd.append("desc", desc);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (rownumber < 0) {
                Toast.fire({
                    icon: 'error',
                    title: 'Opps..!',
                    text: 'Maaf Item belum diinput!'
                });
                e.preventDefault();
            } else {
                $.ajax({
                    url: $('.add-purchase-order').attr('action'),
                    type: $('.add-purchase-order').attr('method'),
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
                            setTimeout('pageRedirect()', 2000);
                        } else {
                            if (responce.message.supplier_id) {
                                $('#supplierName').addClass('is-invalid');
                                $('#errorSupplierId').html(responce.message.supplier_id);
                            } else {
                                $('#supplierName').removeClass('is-invalid');
                                $('#supplierName').addClass('');
                                $('#errorSupplierId').html('');
                            }
                            if (responce.message.warehouse_id) {
                                $('#warehouseId').addClass('is-invalid');
                                $('#errorWarehouseId').html(responce.message.warehouse_id);
                            } else {
                                $('#warehouseId').removeClass('is-invalid');
                                $('#warehouseId').addClass('');
                                $('#errorWarehouseId').html('');
                            }
                        }
                    }
                })
            }
        })

        // store purchase order
        $(document).on('click', '#payment', function(e) {
            e.preventDefault();
            var rownumber = $('table.order-list tbody tr:last').index();
            if (rownumber < 0) {
                Toast.fire({
                    icon: 'error',
                    title: 'Opps..!',
                    text: 'Maaf Item belum diinput!'
                });
                e.preventDefault();
            } else {
                $('#modal-show-payment').modal('show')
            }
        })

        // show purchase price
        $(document).on('click', '#showPurchasePirce', function() {
            let selected = $("#myTable tbody .select-form:checked")
            let id = []
            // looping row selected
            $.each(selected, function(index, responce) {
                id.push(responce.value)
            })
            if ($('.select-form:checked').length == 1) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('purchaselist.showSelected') }}",
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(responce) {
                        $('#modal-show-update-price').modal('show')
                        $("#id").val(responce.data.id);
                        $('#itemCode').val(responce.data.item_code)
                        $('#unit').val(responce.data.unit.unit)
                        $('#selling').val(format_uang(responce.data.selling_price))
                    }
                })
            } else if ($('.select-form:checked').length > 1) {
                Toast.fire({
                    icon: 'error',
                    title: 'Opps..!',
                    text: 'Maaf Item lebih dari 1!'
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Opps..!',
                    text: 'Maaf Item belum dipilih!'
                });
            }
        })

        // update purchase price
        $(document).on('click', '#updatePrice', function(e) {
            e.preventDefault();
            var id = $("#id").val();
            var sellingPrice = $("#selling").val();
            var url = "{{ route('purchaselist.updatePrice', ':id') }}";
            url = url.replace(':id', id);
            var fd = new FormData();
            fd.append("id", id);
            fd.append("selling_price", parseFloat(sellingPrice.replaceAll('.', '')));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: $('.update-price').attr('method'),
                dataType: "JSON",
                processData: false,
                contentType: false,
                data: fd,
                success: function(responce) {
                    if (responce.success == 200) {
                        alert(responce.message)
                        $('#modal-show-update-price').modal('hide');
                    } else {
                        if (responce.message.selling_price) {
                            $('#selling').addClass('is-invalid');
                            $('#errorSellingPrice').html(responce.message.selling_price);
                        } else {
                            $('#selling').removeClass('is-invalid');
                            $('#selling').addClass('');
                            $('#errorSellingPrice').html('');
                        }
                    }
                }
            })
        })

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
                    url: "{{ route('purchaselist.fetchSupplier') }}",
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

        // show search order purchase
        $('.showOrder').on('click', function(e) {
            e.preventDefault();
            var id = $("#supplierId").val();
            var url = "{{ route('purchaselist.orderPurchase', ':id') }}";
            url = url.replace(':id', id);
            if (id != '') {
                $('#modal-show-order').modal('show')
                $("#table-order").DataTable({
                    destroy: true,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: url,
                        type: "GET",
                    },
                    columns: [{
                            data: 'reference_no'
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: 'send_date'
                        },
                        {
                            data: 'warehouse'
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
                });
            } else {
                alert('Pilih supplier terlebih dahulu!')
            }

        })

        // select supplier
        $(document).on('click', '#selectSupplier', function(e) {
            e.preventDefault();
            var id = $(this).attr("value");
            var url = "{{ route('purchaselist.getSupplier', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(responce) {
                    $('#supplierId').val(responce.data.id);
                    $('#supplierName').val(responce.data.supplier_name);
                    $('#modal-show-supplier').modal('hide')
                }
            })
        })

        // select order purchase
        $(document).on('click', '#selectOrder', function(e) {
            e.preventDefault();
            var id = $(this).attr("value");
            var url = "{{ route('purchaselist.getOrderPurchase', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(responce) {
                    $('#orderPurchaseId').val(responce.data.id);
                    $("#referenceNoOrder").prop('readonly');
                    $("#referenceNoOrder").prop('disabled', true);
                    $("#supplierName").prop('readonly');
                    $("#supplierName").prop('disabled', true);
                    $('#referenceNoOrder').val(responce.data.reference_no);
                    $('#sendDate').val(moment(new Date(responce.data.send_date)).format("MM/DD/YYYY"));
                    $('#totalQty').val(parseFloat(responce.data.total_item).toFixed(2))
                    $('#subTotal').val(format_uang(responce.data.total_price))
                    $('input[name="total_qty"]').val(responce.data.total_qty);
                    $('input[name="total_recieved"]').val(responce.data.total_recieved);
                    $('input[name="total_discount"]').val(responce.data.total_discount);
                    $('input[name="total_price"]').val(responce.data.total_price);
                    $('input[name="total_item"]').val(responce.data.total_item);
                    $('input[name="grand_total"]').val(responce.data.grand_total);
                    $('input[name="purchase_status"]').val(responce.data.purchase_status);
                    $('input[name="paid_amount"]').val(responce.data.paid_amount);
                    $('#warehouseId').val(responce.data.warehouse_id)
                    $('#warehouseId').trigger('change');
                    $('#totalRecieved').val(parseFloat(responce.data.total_recieved).toFixed(2))
                    if ($('#orderDiscount').val() != '') {
                        $('#orderDiscount').val(format_uang(responce.data.order_discount))
                    } else {
                        $('#orderDiscount').val(responce.data.order_discount)
                    }
                    $('#grandTotal').val(format_uang(responce.data.grand_total))
                    $('#desc').val(responce.data.desc)
                    $('#modal-show-order').modal('hide')
                    listOrder(id)
                }
            })
        })

        function listOrder(id) {
            $.ajax({
                url: 'listOrderPurchase/' + id,
                type: "GET",
                dataType: "JSON",
                cache: true,
                success: function(responce) {
                    var cols = '';
                    newRow = $('<tr>');
                    for (var i = 0; i < responce['data'].length; i++) {
                        cols += `<tr><td>` +
                            `<input class="checkmark select-form" type="checkbox" value="${responce['data'][i]['item']['id']}">` +
                            `</td>`;
                        cols += `<td>` + responce['data'][i]['id'] + `</td>`;
                        cols += `<td>` + responce['data'][i]['item']['item_code'] + `</td>`;
                        cols += `<td>` + responce['data'][i]['item']['item_name'] + `</td>`;
                        cols += `<td>` +
                            `<input type="number" class="form-control form-control-sm qty" value="${responce['data'][i]['qty']}" name="qty[]" readonly>` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="number" class="form-control form-control-sm recieved" value="${responce['data'][i]['qty']}" name="recieved[]">` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="text" class="form-control form-control-sm" value="${responce['data'][i]['item']['unit']['unit']}"readonly>` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="number" class="form-control form-control-sm discount" value="${responce['data'][i]['discount']}" name="discount[]">` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="number" class="form-control form-control-sm purchasePrice" value="${responce['data'][i]['price']}" name="purchase_price[]">` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="number" class="form-control form-control-sm sub-total" value="${responce['data'][i]['total']}" name="subtotal[]" readonly>` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="text" class="form-control form-control-sm batch-no" name="batch_no[]">` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="text" class="form-control form-control-sm datetimes" name="expired_date[]" value="{{ date('d/m/Y') }}"/>` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="hidden" class="item-code" name="item_code[]" value="${responce['data'][i]['item']['item_code']}"/>` +
                            `</td>`;
                        cols += `<td>` +
                            `<input type="hidden" class="item-id" name="item_id[]" value="${responce['data'][i]['item']['id']}"/>` +
                            `</td>`;
                    }
                    $("table.order-list tbody").append(cols)
                    rowindex = newRow.index();
                    calculateRowitemData(1, 0, responce.data.price);
                }
            })
        }

        // calculation row item
        function calculateRowitemData(quantity, discount, price) {
            var net_unit_cost = price - discount;
            var sub_total = net_unit_cost * quantity;
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sub-total').val(sub_total);
            calculateTotal();
        }

        // calculate total
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

            //Sum of revieved
            var total_recieved = 0;
            $(".recieved").each(function() {
                if ($(this).val() == '') {
                    total_recieved += 0;
                } else {
                    total_recieved += parseFloat($(this).val());
                }
            });
            $("#totalRecieved").val(total_recieved.toFixed(2));
            $('input[name="total_recieved"]').val(total_recieved);

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

        // calculate grand total
        function calculateGrandTotal() {
            var item = $('table.order-list tbody tr:last').index();
            var total_qty = parseFloat($('#totalRecieved').val());
            var subtotal = parseFloat($('input[name="total_price"]').val());
            var order_discount = parseFloat($('input[name="order_discount"]').val());
            if (!order_discount)
                order_discount = 0.00;
            item = ++item + '(' + total_qty + ')';
            var grand_total = subtotal - order_discount;
            $('#item').val(item);
            $('input[name="total_item"]').val($('table.order-list tbody tr:last').index() + 1);
            $('#subTotal').val(format_uang(subtotal));
            $('#order_discount').val(order_discount);
            $('#grandTotal').val(format_uang(grand_total));
            $('input[name="grand_total"]').val(grand_total);
        }
    </script>
@endpush
