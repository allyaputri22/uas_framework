<?php

namespace App\Http\Controllers;

use App\Exports\MahasiswaExport;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Mahasiswa::all();
        return view("data-mahasiswa.index-mahasiswa", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("data-mahasiswa.create-mahasiswa");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi proses penyimpanan data
        $validasi_data = $request->validate([
            'npm' => 'required|string',
            'name' => 'required|string|max:255',
            'prodi' => 'required|string|max:50',
        ]);

        //Proses simpan data ke dalam database
        Mahasiswa::create($validasi_data);

        return redirect()->back()->with('success', 'Mahasiswa created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        if ($mahasiswa) {
            $mahasiswa->delete();
            return redirect()->back()->with('success', 'Data Mahasiswa berhasil dihapus.');
        }
        return redirect()->back()->with('error', 'Data Mahasiswa tidak ditemukan.');
    }

    public function exportExcel (){
        return Excel::download(new MahasiswaExport, 'data-mahasiswa.xlsx');
    }
}
