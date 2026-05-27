<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Role::all();
        return view('admin.role.index', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.role.create');
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
            ]);

            Role::create($validatedData);

            DB::commit();
            return redirect()
                ->route('admin.role.index')
                ->with('success', 'Data berhasil disimpan!');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()
                ->route('admin.role.index')
                ->with('error', 'Gagal menyimpan data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        try{
            DB::beginTransaction();
            $validatedData = $request->validate([
                'name' => 'required',
            ]);

            $role->update($validatedData);

            DB::commit();
            return redirect()
                ->route('admin.role.index')
                ->with('success', 'Data berhasil disimpan!');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()
                ->route('admin.role.index')
                ->with('error', 'Gagal menyimpan data!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try{
            DB::beginTransaction();
            $role->delete();
            DB::commit();
            return redirect()
                ->route('admin.role.index')
                ->with('success', 'Data berhasil dihapus!');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()
                ->route('admin.role.index')
                ->with('error', 'Gagal menghapus data!');
        }
    }
}
