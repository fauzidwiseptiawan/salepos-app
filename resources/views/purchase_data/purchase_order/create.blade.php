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
                                            <label for="brand">No Transaksi</label>
                                            <input type="text" class="form-control" id="brand" name="brand" readonly>
                                            <small id="errorBrand" class="form-text text-muted"></small>
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
                                                <input type="text" class="form-control">
                                                <div class="input-group-append">
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
                                                <option disabled selected>Select..</option>
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
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th width="3%">No</th>
                                            <th width="10%">Kode</th>
                                            <th width="20%">Nama</th>
                                            <th>Jumlah</th>
                                            <th>Jml Terima</th>
                                            <th width="5%">Satuan</th>
                                            <th>Pot %</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th>Batch</th>
                                            <th>Tgl Exp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>BA001</td>
                                            <td>Indomie Goreng Rendang 39 Gram</td>
                                            <td><input type="number" class="form-control form-control-sm"></td>
                                            <td><input type="number" class="form-control form-control-sm" value="0"
                                                    readonly></td>
                                            <td><input type="text" class="form-control form-control-sm" value="PCS"
                                                    readonly></td>
                                            <td><input type="number" class="form-control form-control-sm"></td>
                                            <td><input type="number" class="form-control form-control-sm"></td>
                                            <td><input type="number" class="form-control form-control-sm" value="100.000"
                                                    readonly>
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm"></td>
                                            <td>
                                                <div class="input-group date" id="dateend" data-target-input="nearest">
                                                    <input type="text"
                                                        class="form-control form-control-sm datetimepicker-input"
                                                        data-target="#dateend" id="endDate" name="end_date"
                                                        value="{{ date('d/m/Y') }}" />
                                                    <div class="input-group-append" data-target="#dateend"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            {{-- button table item --}}
                            <div class="col-md-12">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-default float-left" id="addBrand"><i
                                            class="fas fa-plus"></i> Item</button>
                                </div>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-default float-left" id="addBrand"><i
                                            class="fas fa-pen"></i></button>
                                </div>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-default float-left" id="addBrand"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-default float-left" id="addBrand"><i
                                            class="fas fa-question-circle"></i></button>
                                </div>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-default float-left" id="addBrand">Harga
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
                                            <label for="brand">Item</label>
                                            <input type="text" class="form-control text-right" id="brand" name="brand"
                                                readonly>
                                            <small id="errorBrand" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="brand">Terima</label>
                                            <input type="text" class="form-control text-right" id="brand" name="brand"
                                                readonly>
                                            <small id="errorBrand" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="brand">Sub Total</label>
                                            <input type="text" class="form-control text-right" id="brand" name="brand"
                                                readonly>
                                            <small id="errorBrand" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="brand">Pot %</label>
                                            <input type="text" class="form-control  text-right" id="brand" name="brand">
                                            <small id="errorBrand" class="form-text text-muted"></small>
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
                                            <label for="brand">Total Akhir</label>
                                            <input type="text"
                                                class="form-control bg-primary disabled color-palette text-right font-weight-bold"
                                                id="brand" name="brand" value="100.000">
                                            <small id="errorBrand" class="form-text text-muted"></small>
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
@endsection

@push('page-scripts')
@endpush

@push('after-scripts')
    <script>
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
    </script>
@endpush
