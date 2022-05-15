<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Unit;
use App\Imports\UnitImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class UnitController extends Controller
{
    public function index()
    {
        return view('master_data.unit.index');
    }

    public function fetch()
    {
        // fetch unit
        $unit = Unit::orderBy('unit', 'ASC')->get();

        // display result datatable
        return datatables()
            ->of($unit)
            ->addIndexColumn()
            ->addColumn('select_all', function ($unit) {
                return '<input class="checkmark select-form" type="checkbox" value="' . $unit->id . '">';
            })
            ->addColumn('action', function ($unit) {
                return '<div class="dropdown">
                            <button class="btn btn-block btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" id="show" href="javascript:void(0)" value="' . $unit->id . '"><i class="fas fa-edit"></i> Edit</a>
                                <a class="dropdown-item" id="delete" href="javascript:void(0)" value="' . $unit->id . '"><i class="fas fa-trash"></i> Hapus</a>
                            </div>
                        </div>';
            })
            ->rawColumns(['action', 'select_all'])
            ->make(true);
    }

    // function show unit by id
    public function show($id)
    {
        $unit = Unit::find($id);
        return response()->json([
            'success' => 200,
            'message' => 'Berhasil mengabil data satuan!',
            'data'    => $unit
        ]);
    }

    // function create proses
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit' => 'required|unique:unit',
            'desc' => 'required'
        ], [
            'unit.required' => 'Satuan wajib diisi!',
            'unit.unique' => 'Maaf satuan sudah terdaftar!',
            'desc.required' => 'Keterangan wajib diisi!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            Unit::insert([
                'unit' => $request->unit,
                'desc' => $request->desc,
            ]);
            return response()->json([
                'success' => 200,
                'message' => 'Tambah data satuan berhasil',
            ]);
        }
    }

    // function update proses
    public function update(Request $request, $id)
    {
        $unit = Unit::find($id);

        $validator = Validator::make($request->all(), [
            'unit' => "unique:unit,unit," . $unit->id,
            'desc' => 'required',
        ], [
            'unit.required' => 'Satuan wajib diisi!',
            'unit.unique' => 'Maaf satuan sudah terdaftar!',
            'desc.required' => 'Keterangan wajib diisi!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            $unit->update([
                'unit' => $request->unit,
                'desc' => $request->desc,
            ]);
            return response()->json([
                'success' => 200,
                'message' => 'Edit data satuan berhasil',
            ]);
        }
    }

    public function importUnit(Request $request)
    {
        $path = 'upload-excel/';
        $file = $request->file('file');
        $file_name = date('Y-m-d') . '_' . $file->getClientOriginalName();
        $file->storeAs($path, $file_name, 'public');

        Excel::import(new UnitImport, $file);
        return response()->json([
            'success' => 200,
            'message' => 'Import data satuan berhasil!',
        ]);
    }

    public function exportPDFUnit()
    {
        $data = Unit::orderBy('unit', 'ASC')->get();
        $pdf = PDF::loadView('master_data.unit.pdf', compact('data'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->download('santuan.pdf');
    }

    // data function delete selected
    public function destroySelected(Request $request)
    {
        foreach ($request->id as $id) {
            $unit = Unit::find($id);
            $unit->delete();
        }
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data satuan berhasil!',
        ]);
    }

    // function delete
    public function destroy($id)
    {
        $unit = Unit::find($id);
        $unit->delete();
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data satuan berhasil',
        ]);
    }
}
