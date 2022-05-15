<?php

namespace App\Http\Controllers;

use App\Models\Costumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\costumerImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;


class CostumerController extends Controller
{
    public function index()
    {
        return view('master_data.costumer.index');
    }

    public function fetch()
    {
        // fetch costumer
        $costumer = Costumer::orderBy('costumer_name', 'ASC')->get();

        // display result datatable
        return datatables()
            ->of($costumer)
            ->addIndexColumn()
            ->addColumn('select_all', function ($costumer) {
                return '<input class="checkmark select-form" type="checkbox" value="' . $costumer->id . '">';
            })
            ->addColumn('action', function ($costumer) {
                return '<div class="dropdown">
                            <button class="btn btn-block btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" id="show" href="javascript:void(0)" value="' . $costumer->id . '"><i class="fas fa-edit"></i> Edit</a>
                                <a class="dropdown-item" id="delete" href="javascript:void(0)" value="' . $costumer->id . '"><i class="fas fa-trash"></i> Hapus</a>
                            </div>
                        </div>';
            })
            ->rawColumns(['action', 'select_all'])
            ->make(true);
    }

    // function show costumer by id
    public function show($id)
    {
        $costumer = Costumer::find($id);
        return response()->json([
            'success' => 200,
            'message' => 'Berhasil mengambil data pelanggan!',
            'data'    => $costumer
        ]);
    }

    // function create proses
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'costumer_code' => 'required|unique:costumer,costumer_code',
            'costumer_name' => 'required|unique:costumer,costumer_name',
            'phone' => 'required|unique:costumer,phone',
        ], [
            'costumer_code.required' => 'Kode costumer wajib diisi!',
            'costumer_code.unique' => 'Maaf kode costumer sudah terdaftar!',
            'costumer_name.required' => 'Nama costumer wajib diisi!',
            'costumer_name.unique' => 'Maaf nama costumer sudah terdaftar!',
            'phone.required' => 'Nomor telpon wajib diisi!',
            'phone.unique' => 'Maaf Nomor telpon sudah terdaftar!',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            Costumer::insert([
                'costumer_code' => $request->costumer_code,
                'costumer_name' => $request->costumer_name,
                'phone' => $request->phone,
                'city' => $request->city,
                'province' => $request->province,
                'email' => $request->email,
                'address' => $request->address,
                'desc' => $request->desc,
            ]);
            return response()->json([
                'success' => 200,
                'message' => 'Tambah data pelanggan berhasil',
            ]);
        }
    }

    // function update proses
    public function update(Request $request, $id)
    {
        $costumer = Costumer::find($id);

        $validator = Validator::make($request->all(), [
            'costumer_code' => 'required|unique:costumer,costumer_code,' . $costumer->id,
            'costumer_name' => 'required|unique:costumer,costumer_name,' . $costumer->id,
            'phone' => 'required|unique:costumer,phone,' . $costumer->id,
        ], [
            'costumer_code.required' => 'Kode costumer wajib diisi!',
            'costumer_code.unique' => 'Maaf kode costumer sudah terdaftar!',
            'costumer_name.required' => 'Nama costumer wajib diisi!',
            'costumer_name.unique' => 'Maaf nama costumer sudah terdaftar!',
            'phone.required' => 'Nomor telpon wajib diisi!',
            'phone.unique' => 'Maaf Nomor telpon sudah terdaftar!',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            $costumer->update([
                'costumer_code' => $request->costumer_code,
                'costumer_name' => $request->costumer_name,
                'phone' => $request->phone,
                'city' => $request->city,
                'province' => $request->province,
                'email' => $request->email,
                'address' => $request->address,
                'desc' => $request->desc,
            ]);
            return response()->json([
                'success' => 200,
                'message' => 'Edit data pelanggan berhasil',
            ]);
        }
    }

    public function importcostumer(Request $request)
    {
        $path = 'upload-excel/';
        $file = $request->file('file');
        $file_name = date('Y-m-d') . '_' . $file->getClientOriginalName();
        $file->storeAs($path, $file_name, 'public');

        Excel::import(new costumerImport, $file);
        return response()->json([
            'success' => 200,
            'message' => 'Import data pelanggan berhasil!',
        ]);
    }

    public function exportPDFcostumer()
    {
        $data = Costumer::orderBy('costumer_name', 'ASC')->get();
        $pdf = PDF::loadView('master_data.costumer.pdf', compact('data'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('pelanggan.pdf');
    }

    // data function delete selected
    public function destroySelected(Request $request)
    {
        foreach ($request->id as $id) {
            $costumer = Costumer::find($id);
            $costumer->delete();
        }
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data pelanggan berhasil!',
        ]);
    }

    // function delete
    public function destroy($id)
    {
        $costumer = Costumer::find($id);
        $costumer->delete();
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data pelanggan berhasil',
        ]);
    }
}
