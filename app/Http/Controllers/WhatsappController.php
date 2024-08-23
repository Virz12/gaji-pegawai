<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Models\arsip_pesan;
use App\Models\template;
use App\Models\config_api;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

// netflie whatsapp cloud api
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use Netflie\WhatsAppCloudApi\Message\Media\MediaObjectID;
use Netflie\WhatsAppCloudApi\Message\Template\Component;
use Netflie\WhatsAppCloudApi\Message\CtaUrl\TitleHeader;


class WhatsappController extends Controller
{
    protected $whatsapp;

    public function __construct()
    {
        $config = config_api::first();

        $this->whatsapp = new WhatsAppCloudApi([
            'from_phone_number_id' => $config->id_nomor,
            'business_id' =>  $config->id_bisnis,
            'access_token' => $config->token_api,
            'graph_version' => 'v20.0'
        ]);
    }

    public function whatsapp(Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute belum terisi.',
            'pesan_type.required' => 'Silakan pilih tipe pesan Gambar atau Dokumen ',
            'numeric' => ' :attribute hanya berisi angka',
            'nama.regex' => 'Kolom :attribute hanya berisi huruf besar atau kecil dan spasi.',
        ];

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Error!</b><br>Pengiriman Pesan Gagal.');

        $request->validate([
            'nip' => 'required|numeric',
            'nama' => 'required|regex:/^[a-zA-Z ]+$/',
            'nomorWa' => 'required|numeric',
            'header' => 'nullable',
            'body' => 'required',
            'footer' => 'nullable',
            'attachment' => [
                'nullable',
                'file',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('pesan_type') === 'gambar') {
                        if (!in_array($value->getClientOriginalExtension(), ['jpeg', 'jpg', 'png'])) {
                            $fail('Gambar harus berformat jpeg, jpg, atau png.');
                        }
                        if ($value->getSize() >= 5120 * 1024) { 
                            $fail('Ukuran gambar maksimal adalah 5MB.');
                        }
                        if ($value->getSize() <= 2 * 1024) { 
                            $fail('Ukuran gambar minimal adalah 2KB.');
                        }
                    } elseif ($request->input('pesan_type') === 'dokumen') {
                        if (!in_array($value->getClientOriginalExtension(), [
                            'pdf',
                            'txt', 
                            'doc', 
                            'docx',                             
                            'xls', 
                            'xlsx',
                            'ppt',
                            'pptx',
                            ])) {
                            $fail('Dokumen harus berformat pdf, txt, doc, docx, xls, xlsx, ppt, dan pptx');
                        }
                        if ($value->getSize() >= 102400 * 1024) { 
                            $fail('Ukuran dokumen maksimal adalah 100MB.');
                        }
                        if ($value->getSize() <= 2 * 1024) { 
                            $fail('Ukuran dokumen minimal adalah 2KB.');
                        }
                    }
                }
        ],
            'pesan_type' => 'required'
        ], $messages);

        $nip = $request->input('nip');
        $nama = $request->input('nama');
        $nomorWa = $request->input('nomorWa');

        $header = $request->input('header');
        $body = $request->input('body');
        $footer = $request->input('footer');

        $pesan = $header . "\n\n" . $body . "\n\n" . $footer;

        try {
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $path = $file->store('public/attachments');
                $filePath = storage_path('app/' . $path);
                            
                $response = $this->whatsapp->uploadMedia($filePath);
                $media_id = new MediaObjectID($response->decodedBody()['id']);

                $pesanType = $request->input('pesan_type');
                $isSent = false;            

                if ($pesanType === 'gambar') {
                    $isSent = $this->whatsapp->sendImage(
                        $nomorWa, 
                        $media_id, 
                        $pesan);
                } elseif ($pesanType === 'dokumen') {
                    $isSent = $this->whatsapp->sendDocument(
                        $nomorWa, 
                        $media_id, 
                        $file->getClientOriginalName(),
                        $pesan);
                }

                if ($isSent) {
                    $newFileName = File::name($file->getClientOriginalName()) . time() . '.' . $file->extension();
                    $newPath = public_path('attachments/' . $newFileName);
            
                    File::move(storage_path('app/' . $path), $newPath);
            
                    $arsipPesan = arsip_pesan::create([
                        'nip' => $nip,
                        'nama' => $nama,
                        'nomorWa' => $nomorWa,
                        'header' => $header,
                        'body' => $body,
                        'footer' => $footer,
                        'attachment' => $newFileName
                    ]);
            
                    flash()
                    ->killer(true)
                    ->layout('bottomRight')
                    ->timeout(3000)
                    ->success('<b>Berhasil!</b><br>Pesan Terkirim.');
                }
            }else{            
                $this->whatsapp->sendTextMessage($nomorWa, $pesan);

                arsip_pesan::create([
                    'nip' => $nip,
                    'nama' => $nama,
                    'nomorWa' => $nomorWa,
                    'header' => $header,
                    'body' => $body,
                    'footer' => $footer
                ]);
            
                flash()
                ->killer(true)
                ->layout('bottomRight')
                ->timeout(3000)
                ->success('<b>Berhasil!</b><br>Pesan Terkirim.');
            }
        } catch (\Netflie\WhatsAppCloudApi\Response\ResponseException $e) {

            $errorData = $e->responseData();
            $errorCode = $e->httpStatusCode(); 
            // Periksa apakah kode kesalahan adalah 190
            if (isset($errorData['error']['code']) && $errorData['error']['code'] == 190) {

                flash()
                    ->killer(true)
                    ->layout('bottomRight')
                    ->timeout(5000)
                    ->error('<b>Gagal!</b><br>Token expired atau tidak valid.');
            } 
        }

        return redirect('/dashboard');
    }
        
    public function simpantemplate(Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute belum terisi.',
            'unique' => ' :attribute sudah dipakai.',
            'nama_template.regex' => ':attribute hanya berisi huruf besar atau kecil dan angka tanpa spasi'
        ];

        $existingTemplate = template::where('nama_template', $request->input('nama_template'))->first();

        if ($existingTemplate) {
            $request->validate([
                'body' => 'required',
                'footer' => 'nullable',
            ], $messages);

            $existingTemplate->update([ 'body' => $request->input('body'),
                                        'footer' => $request->input('footer')
                                            ]);

            flash()
            ->killer(true)
            ->layout('bottomRight')
            ->timeout(3000)
            ->success('<b>Berhasil!</b><br>Template Diperbarui.');

            return redirect('/dashboard')->withInput();
        } else {
            $request->validate([
                'nama_template' => 'required|regex:/^[a-zA-Z0-9]+$/|unique:template',
                'body' => 'required',
                'footer' => 'nullable',
            ], $messages);

            $data = [   
                'nama_template' => $request->input('nama_template'),
                'body' => $request->input('body'),
                'footer' => $request->input('footer'),
            ];

            if ($template = template::create($data)) {
                flash()
                ->killer(true)
                ->layout('bottomRight')
                ->timeout(3000)
                ->success('<b>Berhasil!</b><br>Template Disimpan.');

                return redirect('/dashboard')->withInput();
            } else {
                flash()
                ->killer(true)
                ->layout('bottomRight')
                ->timeout(3000)
                ->error('<b>Error!</b><br>Template Gagal Disimpan.');
                return redirect('/dashboard');
            }
        }
    }

    public function deletetemplate($id) 
    {   
        $template = template::findOrFail($id);
        $template->delete();

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Template Dihapus.');
        
        return redirect('/dashboard');
    }
}
