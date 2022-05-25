<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemBatch;
use App\Models\ItemPurchase;
use App\Models\ItemWarehouse;
use App\Models\OrderPurchase;
use App\Models\Supplier;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            ->addColumn('created_at', function ($purchase) {
                return date('d/m/Y', strtotime($purchase->created_at));
            })
            ->addColumn('send_date', function ($purchase) {
                return date('d/m/Y', strtotime($purchase->send_date));
            })
            ->addColumn('warehouse', function ($purchase) {
                return $purchase->warehouse->name;
            })
            ->addColumn('supplier', function ($purchase) {
                return $purchase->supplier->supplier_name;
            })
            ->addColumn('total_qty', function ($purchase) {
                return format_uang($purchase->total_qty);
            })
            ->addColumn('total_revieved', function ($purchase) {
                return format_uang($purchase->total_revieved);
            })
            ->addColumn('grand_total', function ($purchase) {
                return format_uang($purchase->grand_total);
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

    // add purchase order
    public function create()
    {
        // format reference no
        $frist = 'PB';
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

    // store purchase order
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'warehouse_id' => 'required',
            'purchase_status' => 'required'
        ], [
            'supplier_id.required' => 'Supplier wajib diisi!',
            'warehouse_id.required' => 'Gudang wajib diisi!',
            'purchase_status.required' => 'Status pesanan wajib diisi!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            OrderPurchase::insert([
                'reference_no' => $request->reference_no,
                'user_id' =>  $user_id,
                'warehouse_id' => $request->warehouse_id,
                'supplier_id' => $request->supplier_id,
                'total_item' => $request->total_item,
                'total_qty' => $request->total_qty,
                'total_recieved' => $request->total_recieved,
                'total_discount' => $request->total_discount,
                'total_price' => $request->total_price,
                'order_discount' => $request->order_discount,
                'grand_total' => $request->grand_total,
                'purchase_status' => $request->purchase_status,
                'payment_status' => $request->payment_status,
                'send_date' => $request->send_date != null ? Carbon::createFromFormat('d/m/Y', $request->send_date)->format('Y-m-d') : null,
                'desc' => $request->desc,
            ]);

            $order_purchase_data = OrderPurchase::latest()->first();
            $item_id = $request->item_id;
            $qty = $request->qty;
            $recieved = $request->recieved;
            $expired_date = $request->expired_date;
            $batch_no = $request->batch_no;
            $discount = $request->discount;
            $purchase_price = $request->purchase_price;
            $total = $request->subtotal;
            $item_purchase = [];

            foreach ($item_id as $i => $id) {
                $item_data = Item::find($id);
                if ($batch_no[$i]) {
                    $item_batch_data = ItemBatch::where([
                        ['item_id', $item_data->id],
                        ['batch_no', $batch_no[$i]]
                    ])->first();
                    if ($item_batch_data) {
                        $item_batch_data->expired_date = Carbon::createFromFormat('d/m/Y', $expired_date[$i])->format('Y-m-d');
                        $item_batch_data->save();
                    } else {
                        $item_batch_data = ItemBatch::create([
                            'item_id' => $item_data->id,
                            'batch_no' => $batch_no[$i],
                            'expired_date' => Carbon::createFromFormat('d/m/Y', $expired_date[$i])->format('Y-m-d'),
                        ]);
                    }
                    $item_purchase['item_batch_id'] = $item_batch_data->id;
                } else {
                    $item_purchase['item_batch_id'] = null;
                }
                if ($item_purchase['item_batch_id']) {
                    $item_warehouse_data = ItemWarehouse::where([
                        ['item_id', $id],
                        ['item_batch_id', $item_purchase['item_batch_id']],
                        ['warehouse_id', $request->warehouse_id],
                    ])->first();
                } else {
                    $item_warehouse_data = ItemWarehouse::where([
                        ['item_id', $id],
                        ['warehouse_id', $request->warehouse_id],
                    ])->first();
                }
                //save to warehouse
                $item_warehouse_data = new ItemWarehouse();
                $item_warehouse_data->item_id = $id;
                $item_warehouse_data->item_batch_id = $item_purchase['item_batch_id'];
                $item_warehouse_data->warehouse_id = $request->warehouse_id;
                $item_warehouse_data->save();

                // save order purchase
                $item_purchase['order_purchase_id'] = $order_purchase_data->id;
                $item_purchase['item_id'] = $id;
                $item_purchase['qty'] = $qty[$i];
                $item_purchase['recieved'] = $recieved[$i];
                $item_purchase['price'] = $purchase_price[$i];
                $item_purchase['discount'] = $discount[$i];
                $item_purchase['total'] = $total[$i];
                ItemPurchase::insert($item_purchase);
            }
            return response()->json([
                'success' => 200,
                'message' => 'Tambah pesanan pembelian baru berhasil',
            ]);
        }
    }

    public function show($id)
    {
        // fetch data id from database
        $supplier = Supplier::orderBy('supplier_name', 'ASC')->get();
        $warehouse = Warehouse::orderBy('name', 'ASC')->get();
        $order_purchase = OrderPurchase::find($id);
        $item_purchases = ItemPurchase::where('order_purchase_id', $id)->with(['item', 'batch'])->get();
        foreach ($item_purchases as $item_purchase) {
            $item_purchase->item->unit;
        }
        return view('purchase_data.purchase_order.update', compact('supplier', 'warehouse', 'order_purchase', 'item_purchases'));
    }

    public function update(Request $request, $id)
    {
        $order_purchase_data = OrderPurchase::find($id);
        $item_purchase_data = ItemPurchase::where('order_purchase_id', $id)->get();
        $user_id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'warehouse_id' => 'required',
            'purchase_status' => 'required'
        ], [
            'supplier_id.required' => 'Supplier wajib diisi!',
            'warehouse_id.required' => 'Gudang wajib diisi!',
            'purchase_status.required' => 'Status pesanan wajib diisi!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {

            $item_id = $request->item_id;
            $qty = $request->qty;
            $recieved = $request->recieved;
            $expired_date = $request->expired_date;
            $batch_no = $request->batch_no;
            $discount = $request->discount;
            $purchase_price = $request->purchase_price;
            $total = $request->subtotal;
            $item_purchase = [];

            foreach ($item_purchase_data as $item_purchase_list) {
                $item_data = Item::find($item_purchase_list->item_id);
                if ($item_purchase_list->item_batch_id) {
                    $item_batch_data = ItemBatch::find($item_purchase_list->item_batch_id);
                    $item_batch_data->save();

                    $item_warehouse = ItemWarehouse::where([
                        ['item_id', $item_purchase_list->item_id],
                        ['item_batch_id', $item_purchase_list->item_batch_id],
                        ['warehouse_id', $order_purchase_data->warehouse_id],
                    ])->first();
                } else {
                    $item_warehouse = ItemWarehouse::where([
                        ['item_id', $item_purchase_list->item_id],
                        ['warehouse_id', $order_purchase_data->warehouse_id],
                    ])->first();
                }
                $item_warehouse->save();
                $item_purchase_list->delete();
            }

            foreach ($item_id as $key => $itm_id) {
                $item_data = Item::find($itm_id);
                if ($batch_no[$key]) {
                    $item_batch_data = ItemBatch::where([
                        ['item_id', $item_data->id],
                        ['batch_no', $batch_no[$key]]
                    ])->first();
                    if ($item_batch_data) {
                        $item_batch_data->expired_date = Carbon::createFromFormat('d/m/Y', $expired_date[$key])->format('Y-m-d');
                        $item_batch_data->save();
                    } else {
                        $item_batch_data = ItemBatch::create([
                            'item_id' => $item_data->id,
                            'batch_no' => $batch_no[$key],
                            'expired_date' => Carbon::createFromFormat('d/m/Y', $expired_date[$key])->format('Y-m-d'),
                        ]);
                    }
                    $item_purchase['item_batch_id'] = $item_batch_data->id;
                } else {
                    $item_purchase['item_batch_id'] = null;
                }
                if ($item_purchase['item_batch_id']) {
                    $item_warehouse_data = ItemWarehouse::where([
                        ['item_id', $itm_id],
                        ['item_batch_id', $item_purchase['item_batch_id']],
                        ['warehouse_id', $request->warehouse_id],
                    ])->first();
                } else {
                    $item_warehouse_data = ItemWarehouse::where([
                        ['item_id', $itm_id],
                        ['warehouse_id', $request->warehouse_id],
                    ])->first();
                }
                //save to warehouse
                if ($item_warehouse_data) {
                    $item_warehouse_data->save();
                } else {
                    $item_warehouse_data = new ItemWarehouse();
                    $item_warehouse_data->item_id = $itm_id;
                    $item_warehouse_data->item_batch_id = $item_purchase['item_batch_id'];
                    $item_warehouse_data->warehouse_id = $request->warehouse_id;
                }
                $item_warehouse_data->save();

                // save order purchase
                $item_purchase['order_purchase_id'] = $id;
                $item_purchase['item_id'] = $itm_id;
                $item_purchase['qty'] = $qty[$key];
                $item_purchase['recieved'] = $recieved[$key];
                $item_purchase['price'] = $purchase_price[$key];
                $item_purchase['discount'] = $discount[$key];
                $item_purchase['total'] = $total[$key];
                ItemPurchase::insert($item_purchase);
            }

            $order_purchase_data->update([
                'reference_no' => $request->reference_no,
                'user_id' =>  $user_id,
                'warehouse_id' => $request->warehouse_id,
                'supplier_id' => $request->supplier_id,
                'total_item' => $request->total_item,
                'total_qty' => $request->total_qty,
                'total_recieved' => $request->total_recieved,
                'total_discount' => $request->total_discount,
                'total_price' => $request->total_price,
                'order_discount' => $request->order_discount,
                'grand_total' => $request->grand_total,
                'purchase_status' => $request->purchase_status,
                'payment_status' => $request->payment_status,
                'send_date' => $request->send_date != null ? Carbon::createFromFormat('d/m/Y', $request->send_date)->format('Y-m-d') : null,
                'desc' => $request->desc,
            ]);

            return response()->json([
                'success' => 200,
                'message' => 'Edit pesanan pembelian baru berhasil',
            ]);
        }
    }

    // data function show selected item
    public function showSelected(Request $request)
    {
        foreach ($request->id as $id) {
            $item = Item::where('id', $id)->with(['brand', 'supplier', 'unit', 'type', 'subtype'])->first();
        }
        return response()->json([
            'success' => 200,
            'message' => 'Ambil data item berhasil!',
            'data' => $item
        ]);
    }

    // data function update item selected
    public function updatePrice(Request $request, $id)
    {
        $item = Item::where('id', $id)->with(['unit'])->first();

        $validator = Validator::make($request->all(), [
            'selling_price' => 'required|regex:/^[0-9.]+$/',
        ], [
            'selling_price.required' => 'Harga jual wajib diisi!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            $item->update([
                'selling_price' => $request->selling_price,
            ]);
            return response()->json([
                'success' => 200,
                'message' => 'Edit harga jual berhasil',
            ]);
        }
    }

    // get item id
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

    // get all supplier
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

    // get all items
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
