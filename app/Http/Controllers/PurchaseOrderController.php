<?php

namespace App\Http\Controllers;

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
        $warehouse = Warehouse::orderBy('name', 'ASC')->get();
        $supplier = Supplier::orderBy('supplier_name', 'ASC')->get();
        return view('purchase_data.purchase_order.create', compact('warehouse', 'supplier'));
    }
    // end function
}
