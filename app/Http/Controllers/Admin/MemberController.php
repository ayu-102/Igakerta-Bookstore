<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PointHistory; // <-- Import Model Riwayat Poin
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $members = $query->paginate(10)->withQueryString();

        return view('admin.members.index', compact('members'));
    }

    public function updatePoints(Request $request, $id)
    {
        $request->validate([
            'points' => 'required|integer|min:0',
        ]);

        $user = User::findOrFail($id);
        $oldPoints = $user->points ?? 0;
        $newPoints = (int) $request->points;
        $diff = $newPoints - $oldPoints;

        // 1. Update jumlah poin di tabel users
        $user->update([
            'points' => $newPoints
        ]);

        // 2. TAMBAHKAN BARIS BARU KE RIWAYAT (Hanya jika ada selisih poin)
        if ($diff != 0) {
            PointHistory::create([
                'user_id' => $user->id,
                'title'   => 'Penyesuaian Poin oleh Admin',
                'type'    => $diff > 0 ? 'earned' : 'used',
                'points'  => abs($diff),
            ]);
        }

        return redirect()->back()->with('success', 'Poin berhasil diperbarui!');
    }
}
