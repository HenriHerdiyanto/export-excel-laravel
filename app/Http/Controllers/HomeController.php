<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        return view('user.home');
    }

    public function adminHome(): View
    {
        $user = User::where('type', '=', '0')->get();
        // dd($user);
        return view('admin.adminHome', compact('user'));
    }

    public function store(Request $request)
    {
        $valisate = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'type' => 'required',
        ]);
        $user = new User();
        $user->name = $valisate['name'];
        $user->email = $valisate['email'];
        $password = $valisate['password'];
        // Hash password menggunakan bcrypt
        $hashedPassword = Hash::make($password);
        // Simpan password yang sudah di-hash ke dalam atribut 'password' pada objek $karyawan
        $user->password = $hashedPassword;
        $user->type = $valisate['type'];
        $user->save();
        return redirect()->back()->with('success', 'ok');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'type' => 'required|in:0,1',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->type = $request->type;
        $user->save();

        return redirect()->back()->with('success', 'User updated successfully.');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'ok');
    }

    // public function managerHome(): View
    // {
    //     return view('managerHome');
    // }
}
