<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Models\DataPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        

        return view('main.dashboard');
    }

    public function tambahpegawai()
    {
        return view('main.tambapegawai');
    }

    public function storepegawai(Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute belum terisi.',
            'numeric' => 'Kolom :attribute hanya boleh berisi angka',
            'nama.regex' => 'Kolom :attribute hanya berisi huruf besar atau kecil',
            'unique' => ':attribute sudah dipakai',
        ];

        // flash()
        // ->killer(true)
        // ->layout('bottomRight')
        // ->timeout(3000)
        // ->error('<b>Error!</b><br>Tambah Siswa Gagal');

        $request->validate([
            'nip' => 'required|numeric|unique:data_pegawai',
            'nama' => 'required|regex:/^[a-zA-Z ]+$/',
            'no_whatsapp' => 'required|numeric',
        ],$messages);

        
        $data = [   
            'nip' => $request->input('nip'),
            'nama' => $request->input('nama'),
            'no_whatsapp' => $request->input('no_whatsapp'),
        ];

        if($datapegawai = DataPegawai::create($data)){
            // flash()
            // ->killer(true)
            // ->layout('bottomRight')
            // ->timeout(3000)
            // ->success('<b>Berhasil!</b><br>Siswa sudah Di Tambah.');

            return redirect('/dashboard')->withInput();
        }else{
            // flash()
            // ->killer(true)
            // ->layout('bottomRight')
            // ->timeout(3000)
            // ->error('<b>Error!</b><br>Tambah Siswa Gagal');
            return redirect('/tambahpegawai');
        }
    }

    public function deletepegawai($id) 
    {   
        $dpegawai = DataPegawai::findOrFail($id);
        $dpegawai->delete();

        // flash()
        // ->killer(true)
        // ->layout('bottomRight')
        // ->timeout(3000)
        // ->success('<b>Berhasil!</b><br>Data Siswa sudah Dihapus.');
        
        return redirect('/dashboard');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function ubahpw()
    {
        return view('main.ubahpassword');
    }

    function updatePassword(Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute belum terisi.',
            'password.min' => 'Kolom :attribute minimal berisi 8 karakter.',
            'password.max' => 'Kolom :attribute maximal berisi 50 karakter.',
            'password.regex'=>'hanya berisi Huruf, Angka(0-9), a-z, A-Z ,karakter khusus yang Diizinkan[!@#$?&*] masing-masing Minimal 1 dan Tanpa Spasi'
        ];

        // flash()
        // ->killer(true)
        // ->layout('bottomRight')
        // ->timeout(3000)
        // ->error('<b>Error!</b><br>Password gagal diubah');

        $request->validate([
            'passwordSekarang' => 'required',
            'password' => ['required','min:8','max:50','regex:/^(?!.*\s)(?=.*[a-z])(?=.*[A-Z])(?!.*[\(\)\-\=\¡\£\_\+\`\~\.\,\<\>\/\;\:\'\"\\\|\[\]\{\}])(?=.*\d)(?=.*[\!\@\#\$\?\&\*]).*$/'],
            'passwordKonfirmasi' => 'required',
        ],$messages);

        $data_user = user::findOrFail(Auth::id());
        $verify_password = Hash::check($request->input('passwordSekarang'),$data_user->password);

        if($verify_password == true)
        {
            if($request->input('password') == $request->input('passwordKonfirmasi'))
            {
                $data_user->update([
                    'password' => $request->input('password'),
                ]);
            } else {
                // flash()
                // ->killer(true)
                // ->layout('bottomRight')
                // ->timeout(3000)
                // ->error('<b>Error!</b><br>Password gagal diubah');

                return redirect('/ubahpassword')->withErrors([
                    'password' => 'Password tidak sama',
                    'passwordKonfirmasi' => 'Password tidak sama'
                ])->withInput();
            }
        }else {
            // flash()
            // ->killer(true)
            // ->layout('bottomRight')
            // ->timeout(3000)
            // ->error('<b>Error!</b><br>Password gagal diubah');
            
            return redirect('/ubahpassword')->withErrors(['passwordSekarang' => 'Password tidak sesuai'])->withInput();
        }
        // flash()
        // ->killer(true)
        // ->layout('bottomRight')
        // ->timeout(3000)
        // ->success('<b>Berhasil!</b><br>Password sudah diubah');

        return redirect('/ubahpassword');
    }
}
