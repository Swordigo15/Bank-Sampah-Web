<?php

namespace App\Http\Controllers;

use App\Models\InputHistory;
use App\Models\Sampah;
use App\Models\User;
use App\Models\UserSampah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function input()
    {
        $sampah = Sampah::all();
        $users = User::where('role_id', 2)->get();
        return view('input', [
            'sampah' => $sampah,
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        try{
            DB::beginTransaction();

            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'jumlah' => 'required|array',
                'jumlah.*' => 'nullable|numeric|min:0.01',
            ]);

            if (empty(array_filter($validatedData['jumlah'], fn ($jumlah) => !is_null($jumlah)))) {
                DB::rollBack();
                return redirect()
                    ->route('input')
                    ->with('error', 'Belum ada jumlah sampah yang diisi!');
            }

            $inputHistory = InputHistory::create([
                'user_id' => $validatedData['user_id'],
            ]);

            foreach ($validatedData['jumlah'] as $sampahId => $jumlah) {
                if (is_null($jumlah)) continue;

                $sampah = Sampah::find($sampahId);
                UserSampah::create([
                    'input_history_id' => $inputHistory->id,
                    'sampah_id' => $sampahId,
                    'total' => $jumlah,
                    'total_harga' => ($jumlah / $sampah->jumlah_satuan) * $sampah->harga,
                ]);
            }

            DB::commit();
            return redirect()
                ->route('input')
                ->with('success', 'Data berhasil disimpan!');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()
                ->route('input')
                ->with('error', 'Gagal menyimpan data! ' . $e->getMessage());
        }
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function riwayat()
    {
        $data = InputHistory::with('user', 'sampahs')->get();
        return view('admin.riwayat.index', compact('data'));
    }

    public function rekap()
    {
        $data = Sampah::with('inputHistory.user')->get();

        // ambil semua bulan unik dari input history
        $months = [];

        foreach ($data as $d) {
            foreach ($d->inputHistory as $history) {
                $bulan = Carbon::parse($history->pivot->created_at)->format('F Y');

                if (!in_array($bulan, $months)) {
                    $months[] = $bulan;
                }
            }
        }

        sort($months);

        return view('admin.rekap.index', compact('data', 'months'));
    }

    public function export($jenis)
    {
        // Implementation for export functionality
    }
}
