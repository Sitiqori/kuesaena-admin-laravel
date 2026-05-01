<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    /* ─── UPDATE PHOTO ─── */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $request->file('photo')->store('profile-photos', 'public');

        $user->update([
            'photo' => $path
        ]);

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    /* ─── PROFIL ─── */
    public function index()
    {
        return view('customer.pages.profil.index');
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'username' => 'nullable|string|max:50',
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . Auth::id(),
            'phone'    => 'nullable|string|max:20',
            'birth_day'   => 'nullable|integer|min:1|max:31',
            'birth_month' => 'nullable|integer|min:1|max:12',
            'birth_year'  => 'nullable|integer|min:1900|max:' . date('Y'),
            'gender'   => 'nullable|in:male,female',
        ]);

        /** @var User $user */
        $user = Auth::user();

        $birth_date = null;
        if ($request->birth_year && $request->birth_month && $request->birth_day) {
            $birth_date = \Carbon\Carbon::createFromDate(
                $request->birth_year,
                $request->birth_month,
                $request->birth_day
            )->toDateString();
        }

        $user->update([
            'username'   => $request->username,
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'birth_date' => $birth_date,
            'gender'     => $request->gender,
        ]);

        return redirect()->route('customer.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    /* ─── ALAMAT ─── */
    public function alamat()
    {
        /** @var User $user */
        $user = Auth::user();

        $addresses = $user->addresses()->get();

        return view('customer.pages.profil.alamat', compact('addresses'));
    }

    public function alamatStore(Request $request)
    {
        $request->validate([
            'label'     => 'required|string|max:50',
            'address'   => 'required|string',
            'phone'     => 'nullable|string|max:20',
        ]);

        /** @var User $user */
        $user = Auth::user();

        $user->addresses()->create($request->only([
            'label','address','kelurahan','kecamatan','kota','provinsi','kode_pos','catatan','phone'
        ]));

        return redirect()->route('customer.profil.alamat')->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function alamatUpdate(Request $request, $id)
    {
        $address = UserAddress::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'label'   => 'required|string|max:50',
            'address' => 'required|string',
            'phone'   => 'nullable|string|max:20',
        ]);

        $address->update($request->only([
            'label','address','kelurahan','kecamatan','kota','provinsi','kode_pos','catatan','phone'
        ]));

        return redirect()->route('customer.profil.alamat')->with('success', 'Alamat berhasil diperbarui.');
    }

    public function alamatDestroy($id)
    {
        $address = UserAddress::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();

        return redirect()->route('customer.profil.alamat')->with('success', 'Alamat berhasil dihapus.');
    }

    /* ─── PASSWORD ─── */
    public function password()
    {
        return view('customer.pages.profil.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:6|confirmed',
        ]);

        /** @var User $user */
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('customer.profil.password')->with('success', 'Password berhasil diubah.');
    }

    /* ─── NOTIFIKASI ─── */
    public function notifikasi()
    {
        return view('customer.pages.profil.notifikasi');
    }

    public function updateNotifikasi(Request $request)
    {
        $field = $request->input('field');
        $allowed = ['notif_whatsapp', 'notif_pesanan', 'notif_promo'];

        if (in_array($field, $allowed)) {
            /** @var User $user */
            $user = Auth::user();

            $user->update([
                $field => $request->has($field),
            ]);
        }

        return redirect()->route('customer.profil.notifikasi')->with('success', 'Pengaturan disimpan.');
    }

    /* ─── PRIVASI ─── */
    public function privasi()
    {
        return view('customer.pages.profil.privasi');
    }

    public function deleteAccount(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Akun berhasil dihapus.');
    }
}
