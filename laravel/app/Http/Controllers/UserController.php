<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::with('role')->get();
        return view('admin.user.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
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
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'role_id' => 'required|exists:roles,id',
            ]);

            User::create($validatedData);

            DB::commit();
            return redirect()
                ->route('admin.user.index')
                ->with('success', 'Data berhasil disimpan!');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()
                ->route('admin.user.index')
                ->with('error', 'Gagal menyimpan data! '. $e->getMessage());
        }
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
        $user = User::find($id);
        $roles = Role::all();
        if(!$user){
            return redirect()
                ->route('admin.user.index')
                ->with('error', 'Data tidak ditemukan!');
        }
        return view('admin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            DB::beginTransaction();
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                'password' => 'nullable|confirmed',
                'role_id' => 'required|exists:roles,id'
            ]);

            if(empty($validatedData['password'])){
                unset($validatedData['password']);
            }
            
            User::find($id)->update($validatedData);

            DB::commit();
            return redirect()
                ->route('admin.user.index')
                ->with('success', 'Data berhasil disimpan!');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()
                ->route('admin.user.index')
                ->with('error', 'Gagal menyimpan data! '. $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            DB::beginTransaction();
            User::find($id)->delete();
            DB::commit();
            return redirect()
                ->route('admin.user.index')
                ->with('success', 'Data berhasil dihapus!');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()
                ->route('admin.user.index')
                ->with('error', 'Gagal menghapus data! '. $e->getMessage());
        }
    }
}
