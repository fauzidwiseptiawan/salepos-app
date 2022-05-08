<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\itemImport;
use App\Models\Brand;
use App\Models\SubType;
use App\Models\Supplier;
use App\Models\Type;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    public function index()
    {
        return view('master_data.item.index');
    }

    public function fetch()
    {
        // fetch item
        $item = Item::orderBy('item_name', 'ASC')->get();

        // display result datatable
        return datatables()
            ->of($item)
            ->addIndexColumn()
            ->addColumn('select_all', function ($item) {
                return '<input class="checkmark select-form" type="checkbox" value="' . $item->id . '">';
            })
            ->addColumn('stock', function ($item) {
                if ($item->stock == '') {
                    return 0;
                } else {
                    return format_uang($item->stock);
                }
            })
            ->addColumn('unit', function ($item) {
                return $item->unit->unit;
            })
            ->addColumn('brand', function ($item) {
                return $item->brand->brand;
            })
            ->addColumn('purchase_price', function ($item) {
                return format_uang($item->purchase_price);
            })
            ->addColumn('selling_price', function ($item) {
                return format_uang($item->selling_price);
            })
            ->addColumn('type', function ($item) {
                return $item->type->type;
            })
            ->addColumn('supplier', function ($item) {
                return $item->supplier->supplier_name;
            })
            ->addColumn('select_all', function ($item) {
                return '<input class="checkmark select-form" type="checkbox" value="' . $item->id . '">';
            })
            ->addColumn('select_all', function ($item) {
                return '<input class="checkmark select-form" type="checkbox" value="' . $item->id . '">';
            })
            ->addColumn('action', function ($item) {
                return '<div class="dropdown">
                            <button class="btn btn-block btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="' . route('itemlist.show', $item->id) . '"><i class="fas fa-edit"></i> Edit</a>
                                <a class="dropdown-item" id="delete" href="' . route('itemlist.destroy', $item->id) . '" value="' . $item->id . '"><i class="fas fa-trash"></i> Hapus</a>
                            </div>
                        </div>';
            })
            ->rawColumns(['action', 'select_all'])
            ->make(true);
    }

    public function getById($id)
    {
        $subtype = SubType::where('type_id', $id)->get();
        return response()->json([
            'success' => 200,
            'message' => 'Berhasil mengambil data subtype!',
            'data'    => $subtype
        ]);
    }

    // add data page function
    public function create()
    {
        $brand = Brand::orderBy('brand', 'ASC')->get();
        $unit = Unit::orderBy('unit', 'ASC')->get();
        $type = Type::orderBy('type', 'ASC')->get();
        $supplier = Supplier::orderBy('supplier_name', 'ASC')->get();
        return view('master_data.item.create', compact('brand', 'supplier', 'type', 'unit'));
    }
    // end function

    // function detail item by id
    public function details($id)
    {
        $items = Item::with(['brand', 'supplier', 'unit', 'type', 'subtype'])->whereHas('brand', function ($query) use ($id) {
            $query->where('item.id', $id);
        })->orderBy("item_name", "ASC")->get();

        return response()->json([
            'success' => 200,
            'message' => 'Berhasil mengambil data item!',
            'data'    => $items
        ]);
    }

    // page display function using id
    public function show($id)
    {
        // fetch data id from database
        $item = Item::find($id);
        $brand = Brand::orderBy('brand', 'ASC')->get();
        $unit = Unit::orderBy('unit', 'ASC')->get();
        $type = Type::orderBy('type', 'ASC')->get();
        $subtype = SubType::orderBy('subtype', 'ASC')->get();
        $supplier = Supplier::orderBy('supplier_name', 'ASC')->get();
        return view('master_data.item.update', compact('item', 'brand', 'supplier', 'type', 'unit', 'subtype'));
    }

    // function create proses
    public function store(Request $request)
    {
        // input validation
        if ($request->promotion != 0) {
            $validator = Validator::make($request->all(), [
                'item_code' => 'required|unique:item,item_code',
                'item_name' => 'required|unique:item,item_name',
                'barcode' => 'unique:item,barcode',
                'unit_id' => 'required',
                'purchase_price' => 'required',
                'selling_price' => 'required',
                'promotion_price' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ], [
                'item_code.required' => 'Kode item wajib diisi!',
                'item_code.unique' => 'Maaf kode item sudah terdaftar!',
                'item_name.required' => 'Nama Item wajib diisi!',
                'item_name.unique' => 'Maaf nama item sudah terdaftar!',
                'unit_id.required' => 'Satuan wajib diisi!',
                'barcode.unique' => 'Maaf barcode sudah terdaftar!',
                'purchase_price.required' => 'Harga pokok wajib diisi!',
                'selling_price.required' => 'Harga jual wajib diisi!',
                'promotion_price.required' => 'Harga promosi wajib diisi!',
                'start_date.required' => 'Tanggal mulai wajib diisi!',
                'end_date.required' => 'Tanggal akhir Item wajib diisi!',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'item_code' => 'required|unique:item,item_code',
                'item_name' => 'required|unique:item,item_name',
                'barcode' => 'unique:item,barcode',
                'unit_id' => 'required',
                'purchase_price' => 'required',
                'selling_price' => 'required',
            ], [
                'item_code.required' => 'Kode item wajib diisi!',
                'item_code.unique' => 'Maaf kode item sudah terdaftar!',
                'item_name.required' => 'Nama Item wajib diisi!',
                'item_name.unique' => 'Maaf nama item sudah terdaftar!',
                'unit_id.required' => 'Satuan wajib diisi!',
                'barcode.unique' => 'Maaf barcode sudah terdaftar!',
                'purchase_price.required' => 'Harga pokok wajib diisi!',
                'selling_price.required' => 'Harga jual wajib diisi!',
            ]);
        }
        // check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            // check if validate by adding image
            if (!$request->hasFile('image') == "") {
                $path = 'item-image/';
                $file = $request->file('image');
                $file_name = time() . '_' . $file->getClientOriginalName();
                $upload = $file->storeAs($path, $file_name, 'public');
                // validation is successful it is saved to the database
                if ($upload) {
                    Item::insert([
                        'type_id' => $request->type_id,
                        'subtype_id' => $request->subtype_id,
                        'brand_id' => $request->brand_id,
                        'unit_id' => $request->unit_id,
                        'supplier_id' => $request->supplier_id,
                        'item_type' => $request->item_type,
                        'item_code' => $request->item_code,
                        'item_name' => $request->item_name,
                        'sale_status' => $request->sale_status,
                        'barcode' => $request->barcode,
                        'stock' => $request->stock,
                        'purchase_price' => $request->purchase_price,
                        'selling_price' => $request->selling_price,
                        'rack' => $request->rack,
                        'is_batch' => $request->is_batch,
                        'promotion' => $request->promotion,
                        'minimum_stock' => $request->minimum_stock,
                        'desc' => $request->desc,
                        'promotion_price' => $request->promotion_price,
                        'start_date' => date("Y-m-d H:i:s", strtotime($request->start_date)),
                        'end_date' => date("Y-m-d H:i:s", strtotime($request->end_date)),
                        'image' => $file_name,
                    ]);
                    return response()->json([
                        'success' => 200,
                        'message' => 'Tambah data item berhasil!',
                    ]);
                }
                // check if validation is not by adding an image
            } else {
                // validation is successful it is saved to the database
                Item::insert([
                    'type_id' => $request->type_id,
                    'subtype_id' => $request->subtype_id,
                    'brand_id' => $request->brand_id,
                    'unit_id' => $request->unit_id,
                    'supplier_id' => $request->supplier_id,
                    'item_type' => $request->item_type,
                    'item_code' => $request->item_code,
                    'item_name' => $request->item_name,
                    'sale_status' => $request->sale_status,
                    'barcode' => $request->barcode,
                    'stock' => $request->stock,
                    'purchase_price' => $request->purchase_price,
                    'selling_price' => $request->selling_price,
                    'rack' => $request->rack,
                    'is_batch' => $request->is_batch,
                    'minimum_stock' => $request->minimum_stock,
                    'promotion' => $request->promotion,
                    'promotion_price' => $request->promotion_price,
                    'start_date' => date("Y-m-d H:i:s", strtotime($request->start_date)),
                    'end_date' => date("Y-m-d H:i:s", strtotime($request->end_date)),
                    'desc' => $request->desc,
                ]);
                return response()->json([
                    'success' => 200,
                    'message' => 'Tambah data item berhasil!',
                ]);
            }
        }
    }

    // function update proses
    public function update(Request $request, $id)
    {
        // fetch data id from database
        $item = Item::find($id);
        // input validation
        $validator = Validator::make($request->all(), [
            'item_code' => 'required|unique:item,item_code,' . $item->id,
            'item_name' => 'required|unique:item,item_name,' . $item->id,
            'barcode' => 'required|unique:item,barcode,' . $item->id,
            'purchase_price' => 'required',
            'selling_price' => 'required',
        ], [
            'item_code.required' => 'Item wajib diisi!',
            'item_code.unique' => 'Maaf item sudah terdaftar!',
            'item_name.required' => 'Nama Item wajib diisi!',
            'item_name.unique' => 'Maaf nama item sudah terdaftar!',
            'barcode.required' => 'Barcode wajib diisi!',
            'barcode.unique' => 'Maaf barcode sudah terdaftar!',
            'purchase_price.required' => 'Harga pokok wajib diisi!',
            'selling_price.required' => 'Harga jual wajib diisi!',
        ]);
        // check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            // check if validate by adding image
            if (!$request->hasFile('image') == "") {
                $path = 'storage/item-image/' . $item->image;
                // check if there is an image file
                if (File::exists($path)) {
                    File::delete($path);
                }
                $path = 'item-image/';
                $file = $request->file('image');
                $file_name = time() . '_' . $file->getClientOriginalName();
                $upload = $file->storeAs($path, $file_name, 'public');
                // validation is successful it is saved to the database
                if ($upload) {
                    $item->update([
                        'type_id' => $request->type_id,
                        'subtype_id' => $request->subtype_id,
                        'brand_id' => $request->brand_id,
                        'unit_id' => $request->unit_id,
                        'supplier_id' => $request->supplier_id,
                        'item_type' => $request->item_type,
                        'item_code' => $request->item_code,
                        'item_name' => $request->item_name,
                        'sale_status' => $request->sale_status,
                        'barcode' => $request->barcode,
                        'stock' => $request->stock,
                        'purchase_price' => $request->purchase_price,
                        'selling_price' => $request->selling_price,
                        'rack' => $request->rack,
                        'is_batch' => $request->is_batch,
                        'minimum_stock' => $request->minimum_stock,
                        'desc' => $request->desc,
                        'promotion' => $request->promotion,
                        'promotion_price' => $request->promotion_price,
                        'start_date' => date("Y-m-d H:i:s", strtotime($request->start_date)),
                        'end_date' => date("Y-m-d H:i:s", strtotime($request->end_date)),
                        'image' => $file_name,
                    ]);
                    return response()->json([
                        'success' => 200,
                        'message' => 'Update data item berhasil!',
                    ]);
                }
                // check if validation is not by adding an image
            } else {
                // validation is successful it is saved to the database
                $item->update([
                    'type_id' => $request->type_id,
                    'subtype_id' => $request->subtype_id,
                    'brand_id' => $request->brand_id,
                    'unit_id' => $request->unit_id,
                    'supplier_id' => $request->supplier_id,
                    'item_type' => $request->item_type,
                    'item_code' => $request->item_code,
                    'item_name' => $request->item_name,
                    'sale_status' => $request->sale_status,
                    'barcode' => $request->barcode,
                    'stock' => $request->stock,
                    'purchase_price' => $request->purchase_price,
                    'selling_price' => $request->selling_price,
                    'rack' => $request->rack,
                    'is_batch' => $request->is_batch,
                    'minimum_stock' => $request->minimum_stock,
                    'promotion' => $request->promotion,
                    'promotion_price' => $request->promotion_price,
                    'start_date' => date("Y-m-d H:i:s", strtotime($request->start_date)),
                    'end_date' => date("Y-m-d H:i:s", strtotime($request->end_date)),
                    'desc' => $request->desc,
                ]);
                return response()->json([
                    'success' => 200,
                    'message' => 'Update data item berhasil!',
                ]);
            }
        }
    }


    public function importitem(Request $request)
    {
        $path = 'upload-excel/';
        $file = $request->file('file');
        $file_name = date('Y-m-d') . '_' . $file->getClientOriginalName();
        $file->storeAs($path, $file_name, 'public');

        Excel::import(new itemImport, $file);
        return response()->json([
            'success' => 200,
            'message' => 'Import data item berhasil!',
        ]);
    }

    public function exportPDFItem()
    {
        $data = Item::orderBy('item_name', 'ASC')->get();

        $pdf = PDF::loadView('master_data.item.pdf', compact('data'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('item.pdf');
    }

    // data function delete selected
    public function destroySelected(Request $request)
    {
        foreach ($request->id as $id) {
            $item = Item::find($id);
            $item->delete();
        }
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data item berhasil!',
        ]);
    }

    // function delete
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data item berhasil',
        ]);
    }
}
