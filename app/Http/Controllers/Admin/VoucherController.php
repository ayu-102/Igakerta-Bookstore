<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->paginate(10);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'         => 'required|unique:vouchers,code|max:50',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'type'         => 'required|in:fixed,percentage',
            'amount'       => 'required|numeric|min:0',
            'min_purchase' => 'required|numeric|min:0',
            'usage_limit'  => 'nullable|integer|min:1', // Validasi batas pemakaian
            'expiry_date'  => 'nullable|date',
            'is_active'    => 'boolean',
        ]);

        Voucher::create([
            'code'         => strtoupper($request->code),
            'title'        => $request->title,
            'description'  => $request->description,
            'type'         => $request->type,
            'amount'       => $request->amount,
            'min_purchase' => $request->min_purchase,
            'usage_limit'  => $request->usage_limit ?? null, // Simpan limit kuota
            'expiry_date'  => $request->expiry_date,
            'is_active'    => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil ditambahkan!');
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'code'         => 'required|max:50|unique:vouchers,code,' . $voucher->id,
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'type'         => 'required|in:fixed,percentage',
            'amount'       => 'required|numeric|min:0',
            'min_purchase' => 'required|numeric|min:0',
            'usage_limit'  => 'nullable|integer|min:1',
            'expiry_date'  => 'nullable|date',
        ]);

        $voucher->update([
            'code'         => strtoupper($request->code),
            'title'        => $request->title,
            'description'  => $request->description,
            'type'         => $request->type,
            'amount'       => $request->amount,
            'min_purchase' => $request->min_purchase,
            'usage_limit'  => $request->usage_limit ?? null,
            'expiry_date'  => $request->expiry_date,
            'is_active'    => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil diperbarui!');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil dihapus!');
    }

    public function toggleStatus(Voucher $voucher)
    {
        $voucher->update(['is_active' => !$voucher->is_active]);
        return back()->with('success', 'Status voucher berhasil diubah!');
    }
}
