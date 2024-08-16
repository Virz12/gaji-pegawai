<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Models\template;
use App\Models\datapegawai;
use App\Models\arsip_pesan;
use App\Models\config_api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class AdminController extends Controller
{
    public function index(Request $request, datapegawai $datapegawai)
    {   
        if ($request->ajax()) {
            $query = $request->get('query');
            $datapegawai = datapegawai::where('nama', 'LIKE', "%{$query}%")->get();

            return response()->json($datapegawai);
        }

        $datatemplate = template::orderBy('nama_template','ASC')->get();
        
        return view('main.dashboard')
                    ->with('datatemplate', $datatemplate)
                    ->with('datapegawai', $datapegawai);
    }

    public function datapegawai(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->get('id');
            $pegawai = datapegawai::find($id);
            
            return response()->json($pegawai);
        }
    }

    public function daftarpegawai(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $datapegawai = datapegawai::whereAny(['nama', 'nip', 'jenis_kelamin', 'nomorWa'], 'LIKE', "%{$query}%")
                ->orderBy('updated_at','DESC')
                ->paginate(5);
    
            return response()->json([
                'data' => $datapegawai->items(),
                'pagination' => (string) $datapegawai->links()
            ]);
        }

        $datapegawai = datapegawai::orderBy('updated_at','DESC')->paginate(5);

        return view('main.daftarpegawai')->with('datapegawai', $datapegawai);
    }

    public function tambahpegawai()
    {
        return view('main.tambahpegawai');
    }

    function storepegawai(Request $request)
    {
        $nipPegawai = datapegawai::where('nip', $request->nip)->first();
        $nomorWaPegawai = datapegawai::where('nomorWa', $request->nomorWa)->first();

        $messages = [
            'required' => 'Kolom :attribute belum terisi.',
            'numeric' => 'Kolom :attribute hanya boleh berisi angka.',
            'nama.regex' => 'Kolom :attribute hanya berisi huruf besar atau kecil dan spasi.',
            'nip.unique' => ":attribute sudah dipakai oleh pegawai dengan nama " . ($nipPegawai ? $nipPegawai->nama : '') . ".",
            'nomorWa.unique' => ":attribute sudah dipakai oleh pegawai dengan nama " . ($nomorWaPegawai ? $nomorWaPegawai->nama : '') . ".",
            'foto_pegawai.image' => 'File Harus Berupa Gambar.',
            'foto_pegawai.max' => 'Ukuran file maksimal 2MB.',            
            'foto_pegawai.mimes' => 'Format Harus JPEG, JPG Dan PNG', 
        ];

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Error!</b><br>Penambahan Pegawai Gagal.');

        $validator = Validator::make($request->all(),[
            'nip' => 'required|numeric|unique:data_pegawai,nip',
            'nama' => 'required|regex:/^[a-zA-Z ]+$/',
            'nomorWa' => 'required|numeric|unique:data_pegawai,nomorWa',
            'jenis_kelamin' => 'required',
            'foto_pegawai' => 'nullable|image|max:2048|mimes:jpeg,jpg,png',
        ],$messages)->validate();

        
        $data = [   
            'nip' => $request->input('nip'),
            'nama' => $request->input('nama'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'nomorWa' => $request->input('nomorWa'),
        ];

        if($datapegawai = datapegawai::create($data)){
            if($request->hasFile('foto_pegawai')) {
                $image = Image::read($request->file('foto_pegawai'));
                $imageName = time() . '.' . $request->file('foto_pegawai')->extension();
                $imagePath = public_path('images/' . $imageName);

                $image->cover(900, 900); 
                $image->save($imagePath);

                $datapegawai->update(['foto_pegawai' => ('images/'.$imageName)]);
            }

            flash()
            ->killer(true)
            ->layout('bottomRight')
            ->timeout(3000)
            ->success('<b>Berhasil!</b><br>Data Pegawai Sudah Ditambah.');

            return redirect('/daftarpegawai')->withInput();
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
        
        $nipPegawai = datapegawai::where('nip', $request->nip)->first();
        $nomorWaPegawai = datapegawai::where('nomorWa', $request->nomorWa)->first();

        $messages = [
            'required' => 'Kolom :attribute belum terisi.',
            'numeric' => 'Kolom :attribute hanya boleh berisi angka.',
            'nama.regex' => 'Kolom :attribute hanya berisi huruf besar atau kecil dan spasi.',
            'nip.unique' => ":attribute sudah dipakai oleh pegawai dengan nama " . ($nipPegawai ? $nipPegawai->nama : '') . ".",
            'nomorWa.unique' => ":attribute sudah dipakai oleh pegawai dengan nama " . ($nomorWaPegawai ? $nomorWaPegawai->nama : '') . ".",
            'digits_between' => 'hanya 1 - 20 digit',
            'foto_pegawai.image' => 'File Harus Berupa Gambar.',
            'foto_pegawai.max' => 'Ukuran file maksimal 2MB.',            
            'foto_pegawai.mimes' => 'Format Harus JPEG, JPG Dan PNG', 
        ];

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Error!</b><br>Pegawai Gagal Diperbarui.');

        Validator::make($request->all(),[
            'nip' => ['required', 'numeric', 'digits_between:1,20', Rule::unique('data_pegawai','nip')->ignore($datapegawai->id)],
            'nama' => 'required|regex:/^[a-zA-Z ]+$/',
            'nomorWa' => ['required', 'numeric',Rule::unique('data_pegawai','nomorWa')->ignore($datapegawai->id) ],
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'foto_pegawai' => 'nullable|image|max:2048|mimes:jpeg,jpg,png',
        ],$messages)->validate();

        
        $data = [   
            'nip' => $request->input('nip'),
            'nama' => $request->input('nama'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'nomorWa' => $request->input('nomorWa'),
        ];

        if ($datapegawai->update($data)) {
            if ($request->hasFile('foto_pegawai')) {
                if (File::exists($datapegawai->foto_pegawai)) {
                    File::delete($datapegawai->foto_pegawai);
                }

                $newImage = Image::read($request->file('foto_pegawai'));
                $imageName = time() . '.' . $request->file('foto_pegawai')->extension();
                $imagePath = public_path('images/' . $imageName);

                $newImage->cover(900, 900); 
                $newImage->save($imagePath);

                $datapegawai->foto_pegawai = 'images/' . $imageName;
            }
            $datapegawai->save();

            flash()
            ->killer(true)
            ->layout('bottomRight')
            ->timeout(3000)
            ->success('<b>Berhasil!</b><br>Data Pegawai Diperbarui.');
            return redirect('/daftarpegawai');
        }else {
            flash()
            ->killer(true)
            ->layout('bottomRight')
            ->timeout(3000)
            ->error('<b>Error!</b><br>Pegawai Gagal Diperbarui.');
            return redirect('/editpegawai');
        }
        
    }

    public function deletepegawai(datapegawai $datapegawai) 
    {   
        datapegawai::destroy($datapegawai->id);

        if (File::exists(public_path($datapegawai->foto_pegawai))) {
            File::delete(public_path($datapegawai->foto_pegawai));
        }

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data Pegawai Sudah Dihapus.');
        
        return redirect('/daftarpegawai');
    }

    public function pesanArsip( Request $request, datapegawai $datapegawai)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $arsipPesan = arsip_pesan::where('nip', $datapegawai->nip)
                                    ->whereAny(['nama', 'pesan', 'attachment','created_at'], 'LIKE', "%{$query}%")
                                    ->orderBy('created_at', 'DESC')
                                    ->paginate(6);

            return response()->json([
                'data' => $arsipPesan->items(),
                'pagination' => (string) $arsipPesan->links()
            ]);
        }

        $arsipPesan = arsip_pesan::orderBy('created_at', 'DESC')
                                    ->where('nip', $datapegawai->nip)
                                    ->paginate(6);

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

    function settings() 
    {
        return view('main.settings');
    }

    function settingsupdate(Request $request) 
    {
        $messages = [
            'required' => 'Kolom :attribute belum terisi.',
        ];

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Error!</b><br>Konfigurasi Gagal.');

        $request->validate([
            'id_nomor' => 'required|string',
            'id_bisnis' => 'required|string',
            'token_api' => 'required|string',
        ] ,$messages);
    
        $config = config_api::first();
    
        if (!$config) {
            $config = new config_api();
        }
        
        $config->id_nomor = $request->input('id_nomor');
        $config->id_bisnis = $request->input('id_bisnis');
        $config->token_api = $request->input('token_api');

        if($config->save()){
            flash()
            ->killer(true)
            ->layout('bottomRight')
            ->timeout(3000)
            ->success('<b>Berhasil!</b><br>Konfigurasi Diubah.');
            return redirect('/dashboard');
        }else {
            flash()
            ->killer(true)
            ->layout('bottomRight')
            ->timeout(3000)
            ->error('<b>Error!</b><br>Konfigurasi Gagal.');
            return redirect('/settings');
        }                
    }
}
