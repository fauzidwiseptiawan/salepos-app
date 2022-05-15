<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\OrderPurchase;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        return view('purchase_data.purchase_order.index');
    }

    public function fetch()
    {
        // fetch purchase
        $purchase = orderPurchase::orderBy('created_at', 'ASC')->get();
        // display result datatable
        return datatables()
            ->of($purchase)
            ->addIndexColumn()
            ->addColumn('select_all', function ($purchase) {
                return '<input class="checkmark select-form" type="checkbox" value="' . $purchase->id . '">';
            })
            ->addColumn('supplier', function ($item) {
                return $item->supplier->supplier_name;
            })
            ->addColumn('warehouse', function ($item) {
                return $item->warehouse->name;
            })
            ->addColumn('action', function ($purchase) {
                return '<div class="dropdown">
                            <button class="btn btn-block btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="' . route('purchaseorderlist.show', $purchase->id) . '"><i class="fas fa-edit"></i> Edit</a>
                                <a class="dropdown-item" id="delete" href="' . route('purchaseorderlist.destroy', $purchase->id) . '" value="' . $purchase->id . '"><i class="fas fa-trash"></i> Hapus</a>
                            </div>
                        </div>';
            })
            ->rawColumns(['action', 'select_all'])
            ->make(true);
    }

    // add data page function
    public function create()
    {
        // format reference no
        $frist = 'BL';
        $second = 'UTM';
        $order = OrderPurchase::max('id');
        $no = 1;
        if ($order) {
            $reference_no =  sprintf("%04s", abs($order + 1)) . '/' . $frist . '/' . $second . '/' .  date('my');
        } else {
            $reference_no = sprintf("%04s", $no) . '/' . $frist . '/' . $second . '/' . date('my');
        }

        $warehouse = Warehouse::orderBy('name', 'ASC')->get();
        $supplier = Supplier::orderBy('supplier_name', 'ASC')->get();
        return view('purchase_data.purchase_order.create', compact('warehouse', 'supplier', 'reference_no'));
    }
    // end function

    // add item to table
    public function getItem($id)
    {
        $item = Item::where('id', $id)->with(['unit'])->first();
        return response()->json([
            'success' => 200,
            'message' => 'Berhasil mengambil data item!',
            'data'    => $item
        ]);
    }

    // function get id supplier
    public function getSupplier($id)
    {
        $supplier = Supplier::find($id);
        return response()->json([
            'success' => 200,
            'message' => 'Berhasil mengambil data supplier!',
            'data'    => $supplier
        ]);
    }

    public function fetchSupplier()
    {
        // fetch supplier
        $supplier = Supplier::orderBy('supplier_name', 'ASC')->get();

        // display result datatable
        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->addColumn('action', function ($supplier) {
                return '<a heref="javascript:void(0)" value="' . $supplier->id . '" id="selectSupplier" class="btn btn-block btn-info btn-sm">Plih</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function fetchItem()
    {
        // fetch supplier
        $item = Item::orderBy('item_name', 'ASC')->get();

        // display result datatable
        return datatables()
            ->of($item)
            ->addIndexColumn()
            ->addColumn('stock', function ($item) {
                if ($item->stock == '') {
                    return 0;
                } else {
                    return format_uang($item->stock);
                }
            })
            ->addColumn('rack', function ($item) {
                if ($item->rack == '') {
                    return "-";
                } else {
                    return $item->rack;
                }
            })
            ->addColumn('unit', function ($item) {
                return $item->unit->unit;
            })
            ->addColumn('brand', function ($item) {
                if ($item->brand_id != null) {
                    return $item->brand->brand;
                } else {
                    return '-';
                }
            })
            ->addColumn('purchase_price', function ($item) {
                return format_uang($item->purchase_price);
            })
            ->addColumn('selling_price', function ($item) {
                return format_uang($item->selling_price);
            })
            ->addColumn('supplier', function ($item) {
                if ($item->supplier_id != null) {
                    return $item->supplier->supplier_name;
                } else {
                    return '-';
                }
            })
            ->addColumn('action', function ($item) {
                return '<a heref="javascript:void(0)" value="' . $item->id . '" id="selectItem" class="btn btn-block btn-info btn-sm">Plih</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
