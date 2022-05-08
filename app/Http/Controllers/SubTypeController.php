<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SubType;
use App\Models\Type;
use App\Imports\SubTypeImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class SubTypeController extends Controller
{
    public function index()
    {
        $type = Type::orderBy('type', 'ASC')->get();
        return view('master_data.subtype.index', compact('type'));
    }

    public function fetch()
    {
        // fetch subType
        $subtype = SubType::orderBy('subtype', 'ASC')->get();
        // display result datatable
        return datatables()
            ->of($subtype)
            ->addIndexColumn()
            ->addColumn('type', function ($subtype) {
                return $subtype->type->type;
            })
            ->addColumn('select_all', function ($subtype) {
                return '<input class="checkmark select-form" type="checkbox" value="' . $subtype->id . '">';
            })
            ->addColumn('action', function ($subtype) {
                return '<div class="dropdown">
                            <button class="btn btn-block btn-outline-primary btn-sm dropdown-toggle" subType="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" id="show" data-toggle="modal" href="' . route('subtypelist.show', $subtype->id) . '" value="' . $subtype->id . '"><i class="fas fa-edit"></i> Edit</a>
                                <a class="dropdown-item" id="delete" href="' . route('subtypelist.destroy', $subtype->id) . '" value="' . $subtype->id . '"><i class="fas fa-trash"></i> Hapus</a>
                            </div>
                        </div>';
            })
            ->rawColumns(['action', 'select_all'])
            ->make(true);
    }

    // function show subType by id
    public function show($id)
    {
        $subtype = SubType::find($id);
        return response()->json([
            'success' => 200,
            'message' => 'Berhasil mengambil data jenis!',
            'data'    => $subtype
        ]);
    }

    // function create proses
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subtype' => 'required|unique:subtype',
            'desc' => 'required',
            'type_id' => 'required'
        ], [
            'subtype.required' => 'Sub jenis wajib diisi!',
            'subtype.unique' => 'Maaf sub jenis sudah terdaftar!',
            'desc.required' => 'Keterangan wajib diisi!',
            'type_id.required' => 'jenis wajib diisi!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            SubType::insert([
                'subtype' => $request->subtype,
                'desc' => $request->desc,
                'type_id' => $request->type_id,
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
        $subtype = SubType::find($id);

        $validator = Validator::make($request->all(), [
            'subtype' => 'required|unique:subtype,subtype,' . $subtype->id,
            'desc' => 'required',
            'type_id' => 'required'
        ], [
            'subtype.required' => 'Sub jenis wajib diisi!',
            'subtype.unique' => 'Maaf sub jenis sudah terdaftar!',
            'desc.required' => 'Keterangan wajib diisi!',
            'type_id.required' => 'jenis wajib diisi!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            $subtype->update([
                'subtype' => $request->subtype,
                'desc' => $request->desc,
                'type_id' => $request->type_id,
            ]);
            return response()->json([
                'success' => 200,
                'message' => 'Edit data sub jenis berhasil',
            ]);
        }
    }

    public function importsubType(Request $request)
    {
        $path = 'upload-excel/';
        $file = $request->file('file');
        $file_name = date('Y-m-d') . '_' . $file->getClientOriginalName();
        $file->storeAs($path, $file_name, 'public');

        Excel::import(new subTypeImport, $file);
        return response()->json([
            'success' => 200,
            'message' => 'Import data sub jenis berhasil!',
        ]);
    }

    public function exportPDFsubType()
    {
        $data = SubType::orderBy('subType', 'ASC')->get();
        $pdf = PDF::loadView('master_data.subType.pdf', compact('data'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->download('sub_jenis.pdf');
    }

    // data function delete selected
    public function destroySelected(Request $request)
    {
        foreach ($request->id as $id) {
            $subtype = SubType::find($id);
            $subtype->delete();
        }
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data jenis berhasil!',
        ]);
    }

    // function delete
    public function destroy($id)
    {
        $subtype = SubType::find($id);
        $subtype->delete();
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data jenis berhasil',
        ]);
    }
}
