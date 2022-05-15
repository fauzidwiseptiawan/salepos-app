<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Bank;
use App\Imports\BankImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class BankController extends Controller
{
    public function index()
    {
        return view('master_data.bank.index');
    }

    public function fetch()
    {
        // fetch bank
        $bank = Bank::orderBy('bank', 'ASC')->get();

        // display result datatable
        return datatables()
            ->of($bank)
            ->addIndexColumn()
            ->addColumn('select_all', function ($bank) {
                return '<input class="checkmark select-form" type="checkbox" value="' . $bank->id . '">';
            })
            ->addColumn('action', function ($bank) {
                return '<div class="dropdown">
                            <button class="btn btn-block btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" id="show" href="javascript:void(0)" value="' . $bank->id . '"><i class="fas fa-edit"></i> Edit</a>
                                <a class="dropdown-item" id="delete" href="javascript:void(0)" value="' . $bank->id . '"><i class="fas fa-trash"></i> Hapus</a>
                            </div>
                        </div>';
            })
            ->rawColumns(['action', 'select_all'])
            ->make(true);
    }

    // function show bank by id
    public function show($id)
    {
        $bank = Bank::find($id);
        return response()->json([
            'success' => 200,
            'message' => 'Berhasil mengambil data bank!',
            'data'    => $bank
        ]);
    }

    // function create proses
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank' => 'required|unique:bank',
            'desc' => 'required'
        ], [
            'bank.required' => 'bank wajib diisi!',
            'bank.unique' => 'Maaf bank sudah terdaftar!',
            'desc.required' => 'Keterangan wajib diisi!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            Bank::insert([
                'bank' => $request->bank,
                'desc' => $request->desc,
            ]);
            return response()->json([
                'success' => 200,
                'message' => 'Tambah data bank berhasil',
            ]);
        }
    }

    // function update proses
    public function update(Request $request, $id)
    {
        $bank = Bank::find($id);

        $validator = Validator::make($request->all(), [
            'bank' => "unique:bank,bank," . $bank->id,
            'desc' => 'required',
        ], [
            'bank.required' => 'bank wajib diisi!',
            'bank.unique' => 'Maaf bank sudah terdaftar!',
            'desc.required' => 'Keterangan wajib diisi!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 400,
                'message' => $validator->errors()->toArray()
            ]);
        } else {
            $bank->update([
                'bank' => $request->bank,
                'desc' => $request->desc,
            ]);
            return response()->json([
                'success' => 200,
                'message' => 'Edit data bank berhasil',
            ]);
        }
    }

    public function importbank(Request $request)
    {
        $path = 'upload-excel/';
        $file = $request->file('file');
        $file_name = date('Y-m-d') . '_' . $file->getClientOriginalName();
        $file->storeAs($path, $file_name, 'public');

        Excel::import(new BankImport, $file);
        return response()->json([
            'success' => 200,
            'message' => 'Import data bank berhasil!',
        ]);
    }

    public function exportPDFbank()
    {
        $data = Bank::orderBy('bank', 'ASC')->get();
        $pdf = PDF::loadView('master_data.bank.pdf', compact('data'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->download('Bank.pdf');
    }

    // data function delete selected
    public function destroySelected(Request $request)
    {
        foreach ($request->id as $id) {
            $bank = Bank::find($id);
            $bank->delete();
        }
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data bank berhasil!',
        ]);
    }

    // function delete
    public function destroy($id)
    {
        $bank = Bank::find($id);
        $bank->delete();
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data bank berhasil',
        ]);
    }
}
