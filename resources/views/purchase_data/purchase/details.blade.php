@extends('layouts.master')
@section('title', 'Detail Pesanan Pembelian Baru')
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

    <div class="invoice p-3 mb-3">
        <!-- title row -->
        <div class="row">
            <div class="col-12">
                <h4>
                    <i class="fas fa-globe"></i> Salepos - App
                    <small class="float-right">Tanggal :
                        {{ date('d/m/Y', strtotime($order_purchase->created_at)) }}</small>
                </h4>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                Dari
                <address>
                    <strong>{{ $order_purchase->warehouse->name }}</strong><br>
                    @if ($order_purchase->warehouse->address == '')
                        - <br>
                    @else
                        {{ $order_purchase->warehouse->address }}<br>
                    @endif
                    Telepon: {{ $order_purchase->warehouse->phone }}<br>
                    @if ($order_purchase->warehouse->email == '')
                        Email: - <br>
                    @else
                        Email: {{ $order_purchase->warehouse->email }}<br>
                    @endif
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                To
                <address>
                    <strong> {{ $order_purchase->supplier->supplier_name }}</strong><br>
                    @if ($order_purchase->supplier->address == '')
                        - <br>
                    @else
                        {{ $order_purchase->supplier->address }}<br>
                    @endif
                    Phone: {{ $order_purchase->supplier->phone }}<br>
                    @if ($order_purchase->supplier->email == '')
                        Email: - <br>
                    @else
                        Email: {{ $order_purchase->supplier->email }}<br>
                    @endif
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Invoice #{{ $order_purchase->reference_no }}</b><br>
                <br>
                <b>Tanggal Pengiriman:</b> {{ date('d/m/Y', strtotime($order_purchase->send_date)) }}<br>
                <b>Dibuat Oleh:</b> {{ strtoupper(Auth::user()->username) }}
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Item</th>
                            <th>Nama Item</th>
                            <th>Jml</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Pot.</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($item_purchases as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->item->item_code }}</td>
                                <td>{{ $item->item->item_name }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->item->unit->unit }}</td>
                                <td>{{ format_uang($item->price) }}</td>
                                <td>{{ $item->discount }}</td>
                                <td>{{ format_uang($item->total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">
                <p class="lead">Keterangan:</p>

                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    @if ($order_purchase->desc == '')
                        -
                    @else
                        {{ $order_purchase->desc }}
                    @endif

                </p>
            </div>
            <!-- /.col -->
            <div class="col-6">
                <p class="lead">Amount Due 2/22/2014</p>

                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>{{ format_uang($order_purchase->total_price) }}</td>
                        </tr>
                        <tr>
                            <th>Potongan</th>
                            <td>{{ format_uang($order_purchase->total_discount) }}</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>{{ format_uang($order_purchase->grand_total) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-12">
                <a href="{{ route('purchaseorderlist.print', $order_purchase->id) }}" rel="noopener" target="_blank"
                    class="btn btn-default"><i class="fas fa-print"></i> Print</a>
            </div>
        </div>
    </div>
    <!-- /.invoice -->

@endsection

@push('page-scripts')
@endpush

@push('after-scripts')
@endpush
