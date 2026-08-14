<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses;
        return view('customer.addresses.index', compact('addresses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'          => 'required|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone_number'   => 'required|string|max:20',
            'address_detail' => 'required|string',
            'city'           => 'required|string|max:100',
            'postal_code'    => 'required|string|max:10',
            'is_default'     => 'nullable|boolean',
        ]);

        $userId = Auth::id();

        // Jika ditandai sebagai utama atau ini alamat pertama, reset alamat lain
        if ($request->has('is_default') || Address::where('user_id', $userId)->count() === 0) {
            Address::where('user_id', $userId)->update(['is_default' => false]);
            $validated['is_default'] = true;
        }

        $validated['user_id'] = $userId;
        Address::create($validated);

        return redirect()->back()->with('success', 'Alamat berhasil ditambahkan!');
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'label'          => 'required|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone_number'   => 'required|string|max:20',
            'address_detail' => 'required|string',
            'city'           => 'required|string|max:100',
            'postal_code'    => 'required|string|max:10',
            'is_default'     => 'nullable|boolean',
        ]);

        if ($request->has('is_default')) {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
            $validated['is_default'] = true;
        }

        $address->update($validated);

        return redirect()->back()->with('success', 'Alamat berhasil diperbarui!');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        return redirect()->back()->with('success', 'Alamat berhasil dihapus!');
    }

    public function setDefault(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        Address::where('user_id', Auth::id())->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return redirect()->back()->with('success', 'Alamat utama berhasil diubah!');
    }
}
