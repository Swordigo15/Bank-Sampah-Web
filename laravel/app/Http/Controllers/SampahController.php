<?php

namespace App\Http\Controllers;

use App\Models\Sampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SampahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Sampah::all();
        return view('admin.sampah.index', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sampah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $validatedData = $request->validate([
                'name' => 'required',
                'harga' => 'required|numeric',
                'jumlah_satuan' => 'required|numeric|min:0',
                'satuan' => 'required'
            ]);

            Sampah::create($validatedData);

            DB::commit();
            return redirect()
                ->route('admin.sampah.index')
                ->with('success', 'Data berhasil disimpan!');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()
                ->route('admin.sampah.index')
                ->with('error', 'Gagal menyimpan data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sampah $sampah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sampah $sampah)
    {
        return view('admin.sampah.edit', compact('sampah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sampah $sampah)
    {
        try{
            DB::beginTransaction();
            $validatedData = $request->validate([
                'name' => 'required',
                'harga' => 'required|numeric',
                'jumlah_satuan' => 'required|numeric|min:0',
                'satuan' => 'required'
            ]);

            $sampah->update($validatedData);

            DB::commit();
            return redirect()
                ->route('admin.sampah.index')
                ->with('success', 'Data berhasil disimpan!');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()
                ->route('admin.sampah.index')
                ->with('error', 'Gagal menyimpan data!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sampah $sampah)
    {
        try{
            DB::beginTransaction();
            $sampah->delete();
            DB::commit();
            return redirect()
                ->route('admin.sampah.index')
                ->with('success', 'Data berhasil dihapus!');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()
                ->route('admin.sampah.index')
                ->with('error', 'Gagal menghapus data!');
        }
    }
}
