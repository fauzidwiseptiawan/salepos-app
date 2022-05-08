<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\warehouseImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class WarehouseController extends Controller
{
    public function index()
    {
        return view('master_data.warehouse.index');
    }

    public function fetch()
    {
        // fetch warehouse
        $warehouse = Warehouse::orderBy('name', 'ASC')->get();

        // display result datatable
        return datatables()
            ->of($warehouse)
            ->addIndexColumn()
            ->addColumn('select_all', function ($warehouse) {
                return '<input class="checkmark select-form" type="checkbox" value="' . $warehouse->id . '">';
            })
            ->addColumn('action', function ($warehouse) {
                return '<div class="dropdown">
                            <button class="btn btn-block btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" id="show" data-toggle="modal" href="' . route('warehouselist.show', $warehouse->id) . '" value="' . $warehouse->id . '"><i class="fas fa-edit"></i> Edit</a>
                                <a class="dropdown-item" id="delete" href="' . route('warehouselist.destroy', $warehouse->id) . '" value="' . $warehouse->id . '"><i class="fas fa-trash"></i> Hapus</a>
                            </div>
                        </div>';
            })
            ->rawColumns(['action', 'select_all'])
            ->make(true);
    }

    // function show warehouse by id
    public function show($id)
    {
        $warehouse = Warehouse::find($id);
        return response()->json([
            'success' => 200,
            'message' => 'Berhasil mengambil data gudang!',
            'data'    => $warehouse
        ]);
    }

    // function create proses
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:warehouse,name',
            'phone' => 'required|unique:warehouse,phone',
        ], [
            'name.required' => 'Nama gudang wajib diisi!',
            'name.unique' => 'Maaf nama gudang sudah terdaftar!',
            'phone.required' => 'Nomor telpon wajib diisi!',
            'phone.unique' => 'Maaf Nomor telpon sudah terdaftar!',
            'desc.required' => 'Keterangan wajib diisi!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            Warehouse::insert([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'desc' => $request->desc,
            ]);
            return response()->json([
                'success' => 200,
                'message' => 'Tambah data gudang berhasil',
            ]);
        }
    }

    // function update proses
    public function update(Request $request, $id)
    {
        $warehouse = Warehouse::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:warehouse,name,' . $warehouse->id,
            'phone' => 'required|unique:warehouse,phone,' . $warehouse->id,
            'desc' => 'required'
        ], [
            'name.required' => 'Nama gudang wajib diisi!',
            'name.unique' => 'Maaf nama gudang sudah terdaftar!',
            'phone.required' => 'Nomor telpon wajib diisi!',
            'phone.unique' => 'Maaf Nomor telpon sudah terdaftar!',
            'desc.required' => 'Keterangan wajib diisi!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            $warehouse->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'desc' => $request->desc,
            ]);
            return response()->json([
                'success' => 200,
                'message' => 'Edit data gudang berhasil',
            ]);
        }
    }

    public function importwarehouse(Request $request)
    {
        $path = 'upload-excel/';
        $file = $request->file('file');
        $file_name = date('Y-m-d') . '_' . $file->getClientOriginalName();
        $file->storeAs($path, $file_name, 'public');

        Excel::import(new warehouseImport, $file);
        return response()->json([
            'success' => 200,
            'message' => 'Import data gudang berhasil!',
        ]);
    }

    public function exportPDFwarehouse()
    {
        $data = Warehouse::orderBy('name', 'ASC')->get();
        $pdf = PDF::loadView('master_data.warehouse.pdf', compact('data'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->download('gudang.pdf');
    }

    // data function delete selected
    public function destroySelected(Request $request)
    {
        foreach ($request->id as $id) {
            $warehouse = Warehouse::find($id);
            $warehouse->delete();
        }
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data gudang berhasil!',
        ]);
    }

    // function delete
    public function destroy($id)
    {
        $warehouse = Warehouse::find($id);
        $warehouse->delete();
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data gudang berhasil',
        ]);
    }
}
