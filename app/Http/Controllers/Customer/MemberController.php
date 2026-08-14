<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PointHistory; // <-- Import Model
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userPoints = $user->points ?? 0;

        // Ambil riwayat poin milik user yang sedang login
        $pointHistories = PointHistory::where('user_id', $user->id)
            ->latest()
            ->get();

        // Tentukan Tier berdasarkan jumlah poin
        if ($userPoints >= 1000) {
            $memberTier = 'Platinum Tier';
        } elseif ($userPoints >= 500) {
            $memberTier = 'Gold Tier';
        } elseif ($userPoints >= 200) {
            $memberTier = 'Silver Tier';
        } else {
            $memberTier = 'Bronze Tier';
        }

        return view('customer.member.index', compact('user', 'userPoints', 'memberTier', 'pointHistories'));
    }
}
