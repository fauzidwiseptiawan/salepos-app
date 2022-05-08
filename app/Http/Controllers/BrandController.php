<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Brand;
use App\Imports\BrandImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class BrandController extends Controller
{
    public function index()
    {
        return view('master_data.brand.index');
    }

    public function fetch()
    {
        // fetch brand
        $brand = Brand::orderBy('brand', 'ASC')->get();

        // display result datatable
        return datatables()
            ->of($brand)
            ->addIndexColumn()
            ->addColumn('select_all', function ($brand) {
                return '<input class="checkmark select-form" type="checkbox" value="' . $brand->id . '">';
            })
            // ->addColumn('image', function ($brand) {
            //     if ($brand->image != '') {
            //         return '<img src="' . asset('storage/brand-image/' . $brand->image) . '" class="img-thumbnail" height="80" width="80" alt="' . asset('storage/brand-image/' . $brand->image) . '">';
            //     } else {
            //         return '<img src="' . asset('template/dist/img/default.png') . '" class="img-thumbnail" height="80" width="80" alt="' . asset('template/dist/img/default.png') . '">';
            //     }
            // })
            ->addColumn('action', function ($brand) {
                return '<div class="dropdown">
                            <button class="btn btn-block btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="' . route('brandlist.show', $brand->id) . '"><i class="fas fa-edit"></i> Edit</a>
                                <a class="dropdown-item" id="delete" href="' . route('brandlist.destroy', $brand->id) . '" value="' . $brand->id . '"><i class="fas fa-trash"></i> Hapus</a>
                            </div>
                        </div>';
            })
            ->rawColumns(['action', 'select_all'])
            ->make(true);
    }

    // add data page function
    public function create()
    {
        return view('master_data.brand.create');
    }
    // end function

    // add data function
    public function store(Request $request)
    {
        // input validation
        $validator = Validator::make($request->all(), [
            'brand' => 'required|unique:brand',
            'desc' => 'required',
        ], [
            'brand.required' => 'Merek wajib diisi!',
            'brand.unique' => 'Maaf merek sudah terdaftar!',
            'desc.required' => 'Keterangan wajib diisi!',
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
                $path = 'brand-image/';
                $file = $request->file('image');
                $file_name = time() . '_' . $file->getClientOriginalName();
                $upload = $file->storeAs($path, $file_name, 'public');
                // validation is successful it is saved to the database
                if ($upload) {
                    Brand::insert([
                        'brand' => $request->brand,
                        'desc' => $request->desc,
                        'image' => $file_name,
                    ]);
                    return response()->json([
                        'success' => 200,
                        'message' => 'Tambah data merek berhasil!',
                    ]);
                }
                // check if validation is not by adding an image
            } else {
                // validation is successful it is saved to the database
                Brand::insert([
                    'brand' => $request->brand,
                    'desc' => $request->desc,
                ]);
                return response()->json([
                    'success' => 200,
                    'message' => 'Tambah data merek berhasil!',
                ]);
            }
        }
    }
    // end function

    // page display function using id
    public function show($id)
    {
        // fetch data id from database
        $brand = Brand::find($id);
        return view('master_data.brand.update', compact('brand'));
    }

    // data update function
    public function update(Request $request, $id)
    {
        // fetch data id from database
        $brand = Brand::find($id);
        // input validation
        $validator = Validator::make($request->all(), [
            'brand' => 'required|unique:brand,brand,' . $brand->id,
            'desc' => 'required',
        ], [
            'brand.required' => 'Merek wajib diisi!',
            'brand.unique' => 'Maaf merek sudah terdaftar!',
            'desc.required' => 'Keterangan wajib diisi!'
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
                $path = 'storage/brand-image/' . $brand->image;
                // check if there is an image file
                if (File::exists($path)) {
                    File::delete($path);
                }
                $path = 'brand-image/';
                $file = $request->file('image');
                $file_name = time() . '_' . $file->getClientOriginalName();
                $upload = $file->storeAs($path, $file_name, 'public');
                // validation is successful it is saved to the database
                if ($upload) {
                    $brand->update([
                        'brand' => $request->brand,
                        'desc' => $request->desc,
                        'image' => $file_name,
                    ]);
                    return response()->json([
                        'success' => 200,
                        'message' => 'Update data merek berhasil!',
                    ]);
                }
                // check if validation is not by adding an image
            } else {
                // validation is successful it is saved to the database
                $brand->update([
                    'brand' => $request->brand,
                    'desc' => $request->desc,
                ]);
                return response()->json([
                    'success' => 200,
                    'message' => 'Update data merek berhasil!',
                ]);
            }
        }
    }

    // data function delete selected
    public function destroySelected(Request $request)
    {
        foreach ($request->id as $id) {
            $brand = Brand::find($id);
            // retrieve image data
            $path = 'storage/brand-image/' . $brand->image;
            // check if there is an image file
            if (File::exists($path)) {
                File::delete($path);
            }
            $brand->delete();
        }
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data merek berhasil!',
        ]);
    }

    public function importBrand(Request $request)
    {
        $path = 'upload-excel/';
        $file = $request->file('file');
        $file_name = date('Y-m-d') . '_' . $file->getClientOriginalName();
        $file->storeAs($path, $file_name, 'public');

        Excel::import(new BrandImport, $file);
        return response()->json([
            'success' => 200,
            'message' => 'Import data merek berhasil!',
        ]);
    }

    public function exportPDFBrand()
    {
        $data = Brand::orderBy('brand', 'ASC')->get();
        $pdf = PDF::loadView('master_data.brand.pdf', compact('data'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->download('merek.pdf');
    }

    // data clear function
    public function destroy($id)
    {
        // fetch data id from database
        $brand = Brand::find($id);
        // retrieve image data
        $path = 'storage/brand-image/' . $brand->image;
        // check if there is an image file
        if (File::exists($path)) {
            File::delete($path);
        }
        $brand->delete();
        return response()->json([
            'success' => 200,
            'message' => 'Hapus data merek berhasil!',
        ]);
    }
}
