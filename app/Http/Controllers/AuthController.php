<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SavedProperty;
use App\Models\VisitSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Transaction;
use App\Models\Inquiry;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            // Jika sudah login, lempar ke dashboard masing-masing role
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // REDIRECT BERDASARKAN ROLE (FIXED)
            return $this->redirectBasedOnRole(Auth::user());
        }

        return redirect()->back()
            ->withErrors(['email' => 'Email atau password salah'])
            ->withInput($request->except('password'));
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.register');
    }

    /**
     * Handle register request
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);

        return $this->redirectBasedOnRole($user);
    }

    /**
     * Helper Function untuk Redirect agar tidak nulis berulang-ulang
     */
    private function redirectBasedOnRole(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang Admin!');
        }

        return redirect()->intended(route('dashboard'))
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    /**
     * Handle logout request
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar di sistem',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Kirim notifikasi reset password
        $user = User::where('email', $request->email)->first();
        $token = \Illuminate\Support\Str::random(60);
        
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['email' => $request->email, 'token' => \Illuminate\Support\Facades\Hash::make($token), 'created_at' => now()]
        );

        // Di environment production, kirim email sungguhan
        // Untuk development, tampilkan link reset di session flash
        try {
            $user->sendPasswordResetNotification($token);
        } catch (\Exception $e) {
            // Jika mail tidak dikonfigurasi, beri info
        }

        return back()->with('success', 'Link reset password telah dikirim ke email Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Anda telah berhasil logout');
    }

    public function profile()
    {
        return view('auth.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'email', 'phone', 'address']);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('profile')->with('success', 'Password berhasil diperbarui!');
    }

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect()->route('home')->with('success', 'Akun Anda telah dihapus.');
    }

    public function toggleFavorite($propertyId)
    {
        $user = Auth::user();

        if ($user->hasSavedProperty($propertyId)) {
            $user->savedProperties()->detach($propertyId);
            return response()->json(['status' => 'removed', 'message' => 'Properti dihapus dari favorit']);
        }

        $user->savedProperties()->attach($propertyId);
        return response()->json(['status' => 'added', 'message' => 'Properti ditambahkan ke favorit']);
    }

    public function savedProperties()
    {
        $user = Auth::user();
        $savedProperties = $user->savedProperties()->latest()->get();
        return view('auth.saved-properties', compact('savedProperties'));
    }

    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $transactions = \App\Models\Transaction::where('user_id', $user->id)
                            ->whereIn('payment_status', ['success', 'pending'])
                            ->with('property')
                            ->latest()
                            ->limit(5)
                            ->get();

        $visitSchedules = $user->visitSchedules()->latest()->limit(3)->get();

        $totalTransactions = \App\Models\Transaction::where('user_id', $user->id)->where('payment_status', 'success')->count();
        $activeBookings = \App\Models\Transaction::where('user_id', $user->id)->where('payment_status', 'success')->count();
        $activeInquiriesCount = Inquiry::where('email', $user->email)->whereNull('reply')->count();
        $savedProperties = $user->savedProperties()->latest()->limit(3)->get();

        return view('auth.dashboard', [
            'user'              => $user,
            'transactions'      => $transactions,
            'visitSchedules'    => $visitSchedules,
            'totalTransactions' => $totalTransactions,
            'activeBookings'    => $activeBookings,
            'activeInquiries'   => $activeInquiriesCount,
            'savedProperties'   => $savedProperties,
        ]);
    }

    public function visitSchedules()
    {
        $user = Auth::user();
        $schedules = $user->visitSchedules()->with('property')->latest()->get();
        return view('auth.visit-schedules', compact('schedules'));
    }

    public function storeVisitSchedule(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'visit_date' => 'required|date|after_or_equal:today',
            'visit_time' => 'required',
            'notes' => 'nullable|string|max:500',
        ]);

        VisitSchedule::create([
            'user_id' => Auth::id(),
            'property_id' => $request->property_id,
            'visit_date' => $request->visit_date,
            'visit_time' => $request->visit_time,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Jadwal kunjungan berhasil diajukan! Menunggu konfirmasi admin.');
    }
}
