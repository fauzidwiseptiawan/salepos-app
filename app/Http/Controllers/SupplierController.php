<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\supplierImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
{
    public function index()
    {
        return view('master_data.supplier.index');
    }

    public function fetch()
    {
        // fetch supplier
        $supplier = Supplier::orderBy('supplier_name', 'ASC')->get();

        // display result datatable
        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->addColumn('select_all', function ($supplier) {
                return '<input class="checkmark select-form" type="checkbox" value="' . $supplier->id . '">';
            })
            ->addColumn('action', function ($supplier) {
                return '<div class="dropdown">
                            <button class="btn btn-block btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" id="show" href="javascript:void(0)" value="' . $supplier->id . '"><i class="fas fa-edit"></i> Edit</a>
                                <a class="dropdown-item" id="delete" href="javascript:void(0)" value="' . $supplier->id . '"><i class="fas fa-trash"></i> Hapus</a>
                            </div>
                        </div>';
            })
            ->rawColumns(['action', 'select_all'])
            ->make(true);
    }

    // function show supplier by id
    public function show($id)
    {
        $supplier = Supplier::find($id);
        return response()->json([
            'success' => 200,
            'message' => 'Berhasil mengambil data supplier!',
            'data'    => $supplier
        ]);
    }

    // function create proses
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_code' => 'required|unique:supplier,supplier_code',
            'supplier_name' => 'required|unique:supplier,supplier_name',
            'phone' => 'required|unique:supplier,phone',
        ], [
            'supplier_code.required' => 'Kode supplier wajib diisi!',
            'supplier_code.unique' => 'Maaf kode supplier sudah terdaftar!',
            'supplier_name.required' => 'Nama supplier wajib diisi!',
            'supplier_name.unique' => 'Maaf nama supplier sudah terdaftar!',
            'phone.required' => 'Nomor telpon wajib diisi!',
            'phone.unique' => 'Maaf Nomor telpon sudah terdaftar!',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            Supplier::insert([
                'supplier_code' => $request->supplier_code,
                'supplier_name' => $request->supplier_name,
                'phone' => $request->phone,
                'city' => $request->city,
                'province' => $request->province,
                'email' => $request->email,
                'address' => $request->address,
                'desc' => $request->desc,
            ]);
            return response()->json([
                'success' => 200,
                'message' => 'Tambah data supplier berhasil',
            ]);
        }
    }

    // function update proses
    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);

        $validator = Validator::make($request->all(), [
            'supplier_code' => 'required|unique:supplier,supplier_code,' . $supplier->id,
            'supplier_name' => 'required|unique:supplier,supplier_name,' . $supplier->id,
            'phone' => 'required|unique:supplier,phone,' . $supplier->id,
        ], [
            'supplier_code.required' => 'Kode supplier wajib diisi!',
            'supplier_code.unique' => 'Maaf kode supplier sudah terdaftar!',
            'supplier_name.required' => 'Nama supplier wajib diisi!',
            'supplier_name.unique' => 'Maaf nama supplier sudah terdaftar!',
            'phone.required' => 'Nomor telpon wajib diisi!',
            'phone.unique' => 'Maaf Nomor telpon sudah terdaftar!',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            $supplier->update([
                'supplier_code' => $request->supplier_code,
                'supplier_name' => $request->supplier_name,
                'phone' => $request->phone,
                'city' => $request->city,
                'province' => $request->province,
                'email' => $request->email,
                'address' => $request->address,
                'desc' => $request->desc,
            ]);
            return response()->json([
                'success' => 200,
                'message' => 'Edit data supplier berhasil',
            ]);
        }
    }

    public function importsupplier(Request $request)
    {
        $path = 'upload-excel/';
        $file = $request->file('file');
        $file_name = date('Y-m-d') . '_' . $file->getClientOriginalName();
        $file->storeAs($path, $file_name, 'public');

        Excel::import(new supplierImport, $file);
        return response()->json([
            'success' => 200,
            'message' => 'Import data supplier berhasil!',
        ]);
    }

    public function exportPDFsupplier()
    {
        $data = Supplier::orderBy('supplier_name', 'ASC')->get();
        $pdf = PDF::loadView('master_data.supplier.pdf', compact('data'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('supplier.pdf');
    }

    // data function delete selected
    public function destroySelected(Request $request)
    {
        foreach ($request->id as $id) {
            $supplier = Supplier::find($id);
            $supplier->delete();
        }
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data supplier berhasil!',
        ]);
    }

    // function delete
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data supplier berhasil',
        ]);
    }
}
