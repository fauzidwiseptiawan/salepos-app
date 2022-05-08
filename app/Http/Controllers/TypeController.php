<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\type;
use App\Imports\typeImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;


class TypeController extends Controller
{
    public function index()
    {
        return view('master_data.type.index');
    }

    public function fetch()
    {
        // fetch type
        $type = Type::orderBy('type', 'ASC')->get();

        // display result datatable
        return datatables()
            ->of($type)
            ->addIndexColumn()
            ->addColumn('select_all', function ($type) {
                return '<input class="checkmark select-form" type="checkbox" value="' . $type->id . '">';
            })
            ->addColumn('action', function ($type) {
                return '<div class="dropdown">
                            <button class="btn btn-block btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" id="show" data-toggle="modal" href="' . route('typelist.show', $type->id) . '" value="' . $type->id . '"><i class="fas fa-edit"></i> Edit</a>
                                <a class="dropdown-item" id="delete" href="' . route('typelist.destroy', $type->id) . '" value="' . $type->id . '"><i class="fas fa-trash"></i> Hapus</a>
                            </div>
                        </div>';
            })
            ->rawColumns(['action', 'select_all'])
            ->make(true);
    }

    // function show type by id
    public function show($id)
    {
        $type = Type::find($id);
        return response()->json([
            'success' => 200,
            'message' => 'Berhasil mengambil data jenis!',
            'data'    => $type
        ]);
    }

    // function create proses
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|unique:type',
            'desc' => 'required'
        ], [
            'type.required' => 'jenis wajib diisi!',
            'type.unique' => 'Maaf jenis sudah terdaftar!',
            'desc.required' => 'Keterangan wajib diisi!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            Type::insert([
                'type' => $request->type,
                'desc' => $request->desc,
            ]);
            return response()->json([
                'success' => 200,
                'message' => 'Tambah data jenis berhasil',
            ]);
        }
    }

    // function update proses
    public function update(Request $request, $id)
    {
        $type = Type::find($id);

        $validator = Validator::make($request->all(), [
            'type' => "unique:type,type," . $type->id,
            'desc' => 'required',
        ], [
            'type.required' => 'jenis wajib diisi!',
            'type.unique' => 'Maaf jenis sudah terdaftar!',
            'desc.required' => 'Keterangan wajib diisi!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            $type->update([
                'type' => $request->type,
                'desc' => $request->desc,
            ]);
            return response()->json([
                'success' => 200,
                'message' => 'Edit data jenis berhasil',
            ]);
        }
    }

    public function importType(Request $request)
    {
        $path = 'upload-excel/';
        $file = $request->file('file');
        $file_name = date('Y-m-d') . '_' . $file->getClientOriginalName();
        $file->storeAs($path, $file_name, 'public');

        Excel::import(new typeImport, $file);
        return response()->json([
            'success' => 200,
            'message' => 'Import data jenis berhasil!',
        ]);
    }

    public function exportPDFType()
    {
        $data = Type::orderBy('type', 'ASC')->get();
        $pdf = PDF::loadView('master_data.type.pdf', compact('data'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->download('jenis.pdf');
    }

    // data function delete selected
    public function destroySelected(Request $request)
    {
        foreach ($request->id as $id) {
            $type = Type::find($id);
            $type->delete();
        }
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data jenis berhasil!',
        ]);
    }

    // function delete
    public function destroy($id)
    {
        $type = Type::find($id);
        $type->delete();
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data jenis berhasil',
        ]);
    }
}
