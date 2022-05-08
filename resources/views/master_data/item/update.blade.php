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
                        <h3 class="card-title">Edit Merek : {{ $item->item_name }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body text-alert">
                        Label bidang yang ditandai dengan * adalah bidang input wajib.
                    </div>
                    <form method="POST" action="{{ route('itemlist.update', $item->id) }}"
                        class="needs-validation update-item" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" id="item_id" value="{{ $item->id }}">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="hidden" name="stock" value="0" id="stock">
                                        <div class="form-group">
                                            <label>Tipe Item</label>
                                            <select value="" id="itemType" class="form-control select2bs4" name="item_type"
                                                style="width: 100%;">
                                                <option {{ $item->item_type == '1' ? 'selected' : '' }} value="1">
                                                    Barang</option>
                                                <option {{ $item->item_type == '2' ? 'selected' : '' }} value="2">
                                                    Jasa</option>
                                                <option {{ $item->item_type == '3' ? 'selected' : '' }} value="3">Non
                                                    Inventory</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="itemName">Nama Item *</strong></label>
                                            <input type="text" class="form-control" id="itemName" name="item_name"
                                                value="{{ $item->item_name }}">
                                            <small id="errorItemName" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="itemCode">Kode Item *</strong></label>
                                            <input type="text" class="form-control" id="itemCode" name="item_code"
                                                value="{{ $item->item_code }}">
                                            <small id="errorItemCode" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Jenis</label>
                                            <select value="" id="typeId" class="form-control select2bs4" name="type_id"
                                                style="width: 100%;">
                                                @foreach ($type as $items)
                                                    <option value="{{ $items->id }}"
                                                        @if ($items->id == $item->type_id) selected @endif>
                                                        {{ $items->type }}</option>
                                                @endforeach
                                            </select>
                                            <small id="errorTypeId" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Sub Jenis</label>
                                            <select value="" id="subTypeId" class="form-control select2bs4"
                                                style="width: 100%;" name="subtype_id">
                                                <option disabled>Select...</option>
                                                @foreach ($subtype as $items)
                                                    <option value="{{ $items->id }}"
                                                        @if ($items->id == $item->subtype_id) selected @endif>
                                                        {{ $items->subtype }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Merek</label>
                                            <select value="" id="brandId" class="form-control select2bs4"
                                                style="width: 100%;" name="brand_id">
                                                <option disabled>Select...</option>
                                                @foreach ($brand as $items)
                                                    <option value="{{ $items->id }}"
                                                        @if ($items->id == $item->brand_id) selected @endif>
                                                        {{ $items->brand }}</option>
                                                @endforeach
                                            </select>
                                            <small id="errorBrandId" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Satuan *</strong></label>
                                            <select value="" id="unitId" class="form-control select2bs4"
                                                style="width: 100%;" name="unit_id">
                                                <option disabled>Select...</option>
                                                @foreach ($unit as $items)
                                                    <option value="{{ $items->id }}"
                                                        @if ($items->id == $item->unit_id) selected @endif>
                                                        {{ $items->unit }}</option>
                                                @endforeach
                                            </select>
                                            <small id="errorUnitId" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Supplier </label>
                                            <select value="" id="supplierId" class="form-control select2bs4"
                                                name="supplier_id" style="width: 100%;">
                                                <option selected disabled>Select...</option>
                                                @foreach ($supplier as $items)
                                                    <option value="{{ $items->id }}"
                                                        @if ($items->id == $item->supplier_id) selected @endif>
                                                        {{ $items->supplier_name }}</option>
                                                @endforeach
                                            </select>
                                            <small id="errorSupplierId" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="stockMinimum">Stok Minimum</label>
                                            <input type="text" class="form-control" id="stockMinimum" name="minimum_stock"
                                                value="{{ $item->minimum_stock }}">
                                            <small id="errorStockMinimum" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="barcode">Barcode</label>
                                            <input type="text" class="form-control" id="barcode" name="barcode"
                                                value="{{ $item->barcode }}">
                                            <small id="errorBarcode" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="purchasePrice">Harga Pokok *</strong></label>
                                            <input type="text" class="form-control" id="purchasePrice"
                                                name="purchase_price" value="{{ $item->purchase_price }}">
                                            <small id="errorPurchasePrice" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sellingPrice">Harga Jual *</strong></label>
                                            <input type="text" class="form-control" id="sellingPrice" name="selling_price"
                                                value="{{ $item->selling_price }}">
                                            <small id="errorSellingPrice" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rack">Rak</label>
                                            <input type="text" class="form-control" id="rack" name="rack"
                                                value="{{ $item->rack }}">
                                            <small id="errorRack" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="taxInclude">Pajak Include %</label>
                                            <input type="text" class="form-control" id="taxInclude" name="tax_include"
                                                value="{{ $item->tax_include }}">
                                            <small id="errorTaxtInclude" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="saleStatus">Status Jual *</strong></label>
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="sale_status"
                                                    id="saleStatus1" value="Still For Sale"
                                                    {{ $item->sale_status == 'Still For Sale' ? ' checked' : '' }}>
                                                <label class="form-check-label" for="saleStatus1">Masih dijual</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="sale_status"
                                                    id="saleStatus1" value="Not Sold"
                                                    {{ $item->sale_status == 'Not Sold' ? ' checked' : '' }}>
                                                <label class="form-check-label" for="saleStatus1">Tidak dijual</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="isBatch" value="1"
                                                    name="is_batch" {{ $item->is_batch == 1 ? ' checked' : '' }}>
                                                <label for="isBatch" class="custom-control-label">Produk ini
                                                    memiliki batch dan tanggal kadaluarsa</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="promotion"
                                                    name="promotion" value="1"
                                                    {{ $item->promotion_price != 1 ? ' checked' : '' }}>
                                                <label for="promotion" class="custom-control-label">Harga
                                                    Promosi</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4" id="promotionPrice">
                                        <div class="form-group">
                                            <label>Harga Promosi *</strong></label>
                                            <input type="text" class="form-control" id="promotionPriceVal"
                                                name="promotion_price" value="{{ $item->promotion_price }}">
                                            <small id="errorPromotion" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" id="dateStart">
                                            <label>Tanggal Mulai *</strong></label>
                                            <div class="input-group date" id="datestart" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input"
                                                    data-target="#datestart" id="startDate" name="start_date"
                                                    @if ($item->start_date == '') value="{{ $item->start_date }}"
                                                    @else
                                                        value="{{ date('m-d-Y', strtotime($item->start_date)) }}" @endif />
                                                <div class="input-group-append" data-target="#datestart"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            <small id="errorStartDate" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" id="dateEnd">
                                            <label for="item">Tanggal Selesai *</strong></label>
                                            <div class="input-group date" id="dateend" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input"
                                                    data-target="#dateend" id="endDate" name="end_date"
                                                    @if ($item->end_date == '') value="{{ $item->end_date }}"
                                                    @else
                                                        value="{{ date('m-d-Y', strtotime($item->end_date)) }}" @endif />
                                                <div class="input-group-append" data-target="#dateend"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            <small id="errorEndDate" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="desc">Keterangan</label>
                                            <textarea class="form-control" rows="5" id="desc" name="desc">{{ $item->desc }}</textarea>
                                            <small id="errordesc" class="form-text text-muted"></small>
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
                                            <span style="font-size: 13px">NB : ukuran gambar = 125x125</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('template/dist/img/default.png') }}" id="box"
                                            class="rounded mx-auto d-block" width="50%"
                                            alt="{{ asset('template/dist/img/default.png') }}">
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right" id="updateItem">Simpan</button>
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
        //Date picker
        $('#datestart').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#dateend').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        // jika promosi tidak diganti
        $("#promotion").ready(function() {
            if ($('#promotion').is(':checked')) {
                $("#promotionPrice").show();
                $("#dateStart").show();
                $("#dateEnd").show();
            } else {
                $("#promotionPrice").hide();
                $("#dateStart").hide();
                $("#dateEnd").hide();
            }
        });

        // jika promosi di ganti
        $("#promotion").on("change", function() {
            if ($(this).is(':checked')) {
                $("#promotionPrice").show(300);
                $("#dateStart").show(300);
                $("#dateEnd").show(300);
            } else {
                $("#promotionPrice").hide(300);
                $("#dateStart").hide(300);
                $("#dateEnd").hide(300);
            }
        });


        // select subtype
        $(document).ready(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            $('#typeId').on('change', function() {
                let id = $(this).val()
                var url = "{{ route('itemlist.getById', ':id') }}";
                url = url.replace(':id', id);
                $('#subTypeId').empty()
                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'JSON',
                    success: function(responce) {
                        // console.log(responce['data']);
                        var isi = '';
                        for (var i = 0; i < responce['data'].length; i++) {
                            isi +=
                                `<option value="${responce['data'][i]['id']}" selected>${responce['data'][i]['subtype']}</option>`;
                            $('#subTypeId').html(isi);
                        }
                    }
                })

            })
        })

        // show sweetalert
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

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

        // function pageRedirect
        function pageRedirect() {
            window.location = "{{ route('itemlist.index') }}";
        }

        // add item
        $(document).on("click", "#updateItem", function(e) {
            e.preventDefault();

            var method = $("input[name='_method']").attr('value');
            var id = $("#item_id").val();
            var itemType = $("#itemType").val();
            var itemName = $("#itemName").val();
            var itemCode = $("#itemCode").val();
            var typeId = $("#typeId").val();
            var subTypeId = $("#subTypeId").val();
            var brandId = $("#brandId").val();
            var unitId = $("#unitId").val();
            var supplierId = $("#supplierId").val();
            var stock = $("#stock").val();
            var stockMinimum = $("#stockMinimum").val();
            var barcode = $("#barcode").val();
            var purchasePrice = $("#purchasePrice").val();
            var sellingPrice = $("#sellingPrice").val();
            var rack = $("#rack").val();
            var taxInclude = $("#taxInclude").val();
            var saleStatus = $("#saleStatus1").is(':checked');
            var rack = $("#rack").val();
            var isBatch = $("#isBatch").is(':checked');
            var promotion = $("#promotion").is(':checked')
            var promotionPrice = $("#promotionPriceVal").val();
            var dateStart = $("#startDate").val();
            var dateEnd = $("#endDate").val();
            var desc = $("#desc").val();
            var image = $("#image")[0].files[0];

            var fd = new FormData();
            fd.append("_method", method)
            fd.append("id", id);
            fd.append("item_type", itemType);
            fd.append("item_name", itemName);
            fd.append("item_code", itemCode);
            fd.append("type_id", typeId);
            fd.append("subtype_id", subTypeId);
            fd.append("brand_id", brandId);
            fd.append("unit_id", unitId);
            fd.append("supplier_id", supplierId);
            fd.append("minimum_stock", stockMinimum);
            fd.append("stock", stock);
            fd.append("barcode", barcode);
            fd.append("purchase_price", purchasePrice);
            fd.append("selling_price", sellingPrice);
            fd.append("rack", rack);
            fd.append("tax_include", taxInclude);
            fd.append("promotion_price", promotionPrice);
            fd.append("start_date", dateStart);
            fd.append("end_date", dateEnd);
            fd.append("desc", desc);
            fd.append("image", image);

            if (promotion == '') {
                fd.append("is_batch", '0');
            } else {
                fd.append("is_batch", '1');
            }

            if (isBatch == '') {
                fd.append("isBatch", '0');
            } else {
                fd.append("isBatch", '1');
            }

            if (saleStatus == '1') {
                fd.append("sale_status", '1');
            } else {
                fd.append("sale_status", '2');
            }

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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: $('.update-item').attr('action'),
                type: $('.update-item').attr('method'),
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
                        if (responce.message.item_name) {
                            $('#itemName').addClass('is-invalid');
                            $('#errorItemName').html(responce.message.item_name);
                        } else {
                            $('#itemName').removeClass('is-invalid');
                            $('#itemName').addClass('');
                            $('#errorItemName').html('');
                        }
                        if (responce.message.item_code) {
                            $('#itemCode').addClass('is-invalid');
                            $('#errorItemCode').html(responce.message.item_code);
                        } else {
                            $('#itemCode').removeClass('is-invalid');
                            $('#itemCode').addClass('');
                            $('#errorItemCode').html('');
                        }
                        if (responce.message.purchase_price) {
                            $('#purchasePrice').addClass('is-invalid');
                            $('#errorPurchasePrice').html(responce.message.purchase_price);
                        } else {
                            $('#purchasePrice').removeClass('is-invalid');
                            $('#purchasePrice').addClass('');
                            $('#errorPurchasePrice').html('');
                        }
                        if (responce.message.selling_price) {
                            $('#sellingPrice').addClass('is-invalid');
                            $('#errorSellingPrice').html(responce.message.selling_price);
                        } else {
                            $('#sellingPrice').removeClass('is-invalid');
                            $('#sellingPrice').addClass('');
                            $('#errorSellingPrice').html('');
                        }
                        if (responce.message.unit_id) {
                            $('#unitId').addClass('is-invalid');
                            $('#errorUnitId').html(responce.message.unit_id);
                        } else {
                            $('#unitId').removeClass('is-invalid');
                            $('#unitId').addClass('');
                            $('#errorUnitId').html('');
                        }
                        if (responce.message.promotion_price) {
                            $('#promotionPriceVal').addClass('is-invalid');
                            $('#errorPromotion').html(responce.message.promotion_price);
                        } else {
                            $('#promotionPriceVal').removeClass('is-invalid');
                            $('#promotionPriceVal').addClass('');
                            $('#errorPromotion').html('');
                        }
                        if (responce.message.start_date) {
                            $('#startDate').addClass('is-invalid');
                            $('#errorStartDate').html(responce.message.start_date);
                        } else {
                            $('#startDate').removeClass('is-invalid');
                            $('#startDate').addClass('');
                            $('#errorStartDate').html('');
                        }
                        if (responce.message.end_date) {
                            $('#endDate').addClass('is-invalid');
                            $('#errorEndDate').html(responce.message.end_date);
                        } else {
                            $('#endDate').removeClass('is-invalid');
                            $('#endDate').addClass('');
                            $('#errorEndDate').html('');
                        }
                    }
                }
            })
        })
    </script>
@endpush
