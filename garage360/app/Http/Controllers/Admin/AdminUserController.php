<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::withCount('orders')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return back()->with('success', $user->name . ' güncellendi.');
    }

    public function toggleActive(User $user)
    {
        if ($user->hasRole('admin')) {
            return back()->with('error', 'Admin hesabı dondurulamaz.');
        }

        $user->update(['is_active' => !$user->is_active]);
        $msg = $user->is_active ? 'Hesap aktifleştirildi.' : 'Hesap donduruldu.';

        return back()->with('success', $msg);
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            return back()->with('error', 'Admin hesabı silinemez.');
        }

        $user->delete();

        return back()->with('success', 'Kullanıcı silindi.');
    }

    public function addBalance(Request $request, User $user)
    {
        $request->validate(['amount' => 'required|numeric|min:0.01']);

        $balance = UserBalance::firstOrCreate(['user_id' => $user->id], ['amount' => 0]);
        $balance->increment('amount', $request->amount);

        return back()->with('success', number_format($request->amount, 2) . ' ₺ bakiye eklendi.');
    }
}
