<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Models\template;
use App\Models\datapegawai;
use App\Models\arsip_pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $query = $request->get('query');
            $datapegawai = datapegawai::where('nama', 'LIKE', "{$query}%")->get();

            return response()->json($datapegawai);
        }
        $datapegawai = datapegawai::orderBy('updated_at','DESC')->get();

        $datatemplate = template::orderBy('nama_template','ASC')->get();
        
        return view('main.dashboard')
                    ->with('datatemplate', $datatemplate)
                    ->with('datapegawai', $datapegawai);
    }

    public function tambahpegawai()
    {
        return view('main.tambahpegawai');
    }

    function storepegawai(Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute belum terisi.',
            'numeric' => 'Kolom :attribute hanya boleh berisi angka.',
            'nama.regex' => 'Kolom :attribute hanya berisi huruf besar atau kecil dan spasi.',
            'unique' => ':attribute sudah dipakai.',
        ];

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Error!</b><br>Penambahan Pegawai Gagal.');

        $request->validate([
            'nip' => 'required|numeric|unique:data_pegawai',
            'nama' => 'required|regex:/^[a-zA-Z ]+$/',
            'nomorWa' => 'required|numeric',
        ],$messages);

        
        $data = [   
            'nip' => $request->input('nip'),
            'nama' => $request->input('nama'),
            'nomorWa' => $request->input('nomorWa'),
        ];

        if($datapegawai = datapegawai::create($data)){
            flash()
            ->killer(true)
            ->layout('bottomRight')
            ->timeout(3000)
            ->success('<b>Berhasil!</b><br>Data Pegawai Sudah Ditambah.');

            return redirect('/dashboard')->withInput();
        }else{
            flash()
            ->killer(true)
            ->layout('bottomRight')
            ->timeout(3000)
            ->error('<b>Error!</b><br>Penambahan Pegawai Gagal.');
            return redirect('/tambahpegawai');
        }
    }
    
    public function editpegawai(datapegawai $datapegawai)
    {

        return view('main.editpegawai')
                    ->with('datapegawai', $datapegawai);
    }

    function updatepegawai(Request $request, datapegawai $datapegawai)
    {
        $messages = [
            'required' => 'Kolom :attribute belum terisi.',
            'numeric' => 'Kolom :attribute hanya boleh berisi angka.',
            'nama.regex' => 'Kolom :attribute hanya berisi huruf besar atau kecil dan spasi.',
            'unique' => ':attribute sudah dipakai.',
            'digits_between' => 'hanya 1 - 20 digit',
        ];

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Error!</b><br>Pegawai Gagal Diperbarui.');

        Validator::make($request->all(),[
            'nip' => ['required', 'numeric', 'digits_between:1,20', Rule::unique('data_pegawai','nip')->ignore($datapegawai->id)],
            'nama' => 'required|regex:/^[a-zA-Z ]+$/',
            'nomorWa' => 'required|numeric',
        ],$messages)->validate();

        
        $data = [   
            'nip' => $request->input('nip'),
            'nama' => $request->input('nama'),
            'nomorWa' => $request->input('nomorWa'),
        ];

        if($datapegawai->update($data)){
            $datapegawai->save();

            flash()
            ->killer(true)
            ->layout('bottomRight')
            ->timeout(3000)
            ->success('<b>Berhasil!</b><br>Data Pegawai Diperbarui.');

            return redirect('/dashboard')->withInput();
        }else{
            flash()
            ->killer(true)
            ->layout('bottomRight')
            ->timeout(3000)
            ->error('<b>Error!</b><br>Pegawai Gagal Diperbarui.');
            return redirect('/editpegawai');
        }
    }

    public function deletepegawai($id) 
    {   
        $dpegawai = datapegawai::findOrFail($id);
        $dpegawai->delete();

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data Pegawai Sudah Dihapus.');
        
        return redirect('/dashboard');
    }

    public function pesanarsip(datapegawai $datapegawai, Request $request)
    {
        if ($request->ajax()) {
            $arsipPesan = arsip_pesan::orderBy('created_at', 'DESC')
                                    ->paginate(8);
        }

        $arsipPesan = arsip_pesan::orderBy('created_at', 'DESC')
                                    ->paginate(8);

        return view('main.arsip')
                ->with('arsipPesan', $arsipPesan)
                ->with('datapegawai', $datapegawai);
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

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Error!</b><br>Perubahan Password Gagal.');

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
                flash()
                ->killer(true)
                ->layout('bottomRight')
                ->timeout(3000)
                ->error('<b>Error!</b><br>Perubahan Password Gagal.');

                return redirect('/ubahpassword')->withErrors([
                    'password' => 'Password tidak sama',
                    'passwordKonfirmasi' => 'Password tidak sama'
                ])->withInput();
            }
        }else {
            flash()
            ->killer(true)
            ->layout('bottomRight')
            ->timeout(3000)
            ->error('<b>Error!</b><br>Perubahan Password Gagal.');
            
            return redirect('/ubahpassword')->withErrors(['passwordSekarang' => 'Password tidak sesuai'])->withInput();
        }
        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Password Sudah Diubah.');

        return redirect('/ubahpassword');
    }
}
