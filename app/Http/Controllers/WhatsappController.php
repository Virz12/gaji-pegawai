<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Models\arsip_pesan;
use App\Models\template;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use Netflie\WhatsAppCloudApi\Message\Media\MediaObjectID;
use Netflie\WhatsAppCloudApi\Message\Template\Component;
use Netflie\WhatsAppCloudApi\Message\Contact\ContactName;
use Netflie\WhatsAppCloudApi\Message\Contact\Phone;
use Netflie\WhatsAppCloudApi\Message\Contact\PhoneType;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Row;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Section;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Action;
use Netflie\WhatsAppCloudApi\Message\CtaUrl\TitleHeader;
use Netflie\WhatsAppCloudApi\Message\ButtonReply\Button;
use Netflie\WhatsAppCloudApi\Message\ButtonReply\ButtonAction;


class WhatsappController extends Controller
{
    protected $whatsapp;

    public function __construct()
    {
        $this->whatsapp = new WhatsAppCloudApi([
            'from_phone_number_id' => env('WHATSAPP_CLOUD_API_FROM_PHONE_NUMBER'),
            'access_token' => env('WHATSAPP_CLOUD_API_TOKEN'),
            'graph_version' => 'v20.0'
        ]);
    }

    public function whatsapp(Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute belum terisi.',
            'pesan_type.required' => 'Silakan pilih tipe pesan Gambar atau Dokumen ',
            'numeric' => ' :attribute hanya berisi angka',

        ];

        $request->validate([
            'nomorWa' => 'required|numeric',
            'pesan' => 'required',
            'attachment' => [
                'nullable',
                'file',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('pesan_type') === 'gambar') {
                        if (!in_array($value->getClientOriginalExtension(), ['jpeg', 'jpg', 'png'])) {
                            $fail('Gambar harus berformat jpeg, jpg, atau png.');
                        }
                        if ($value->getSize() > 5120 * 1024) { 
                            $fail('Ukuran gambar maksimal adalah 5MB.');
                        }
                        if ($value->getSize() < 5 * 1024) { 
                            $fail('Ukuran gambar minimal adalah 5KB.');
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
                        if ($value->getSize() > 102400 * 1024) { 
                            $fail('Ukuran dokumen maksimal adalah 100MB.');
                        }
                        if ($value->getSize() < 5 * 1024) { 
                            $fail('Ukuran dokumen minimal adalah 5KB.');
                        }
                    }
                }
        ],
            'pesan_type' => 'required'
        ], $messages);

        $nomorWa = $request->input('nomorWa');
        $pesan = $request->input('pesan');
        
        try {
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $path = $file->store('public/attachments');
                $filePath = storage_path('app/' . $path);
                
                $response = $this->whatsapp->uploadMedia($filePath);
                $media_id = new MediaObjectID($response->decodedBody()['id']);

                $pesanType = $request->input('pesan_type');
                if ($pesanType === 'gambar') {
                    $this->whatsapp->sendImage(
                        $nomorWa, 
                        $media_id, 
                        $pesan);
                } elseif ($pesanType === 'dokumen') {
                    $this->whatsapp->sendDocument(
                        $nomorWa, 
                        $media_id, 
                        $file->getClientOriginalName(),
                        $pesan);
                }

                Storage::delete($path);
            }else{
                $this->whatsapp->sendTextMessage($nomorWa, $pesan);
            }

        // arsip_pesan::create([
        //     'to' => $to,
        //     'pesan' => $pesan,
        //     'attachment' => $file->getClientOriginalName()
        // ]);

            flash()
            ->killer(true)
            ->layout('bottomRight')
            ->timeout(3000)
            ->success('<b>Berhasil!</b><br>Pesan Terkirim.');

        } catch (\Exception $e) {
                Storage::delete($path);
                flash()
                ->killer(true)
                ->layout('bottomRight')
                ->timeout(3000)
                ->error('<b>Error!</b><br>Terjadi kesalahan saat mengupload file: '. $e->getMessage());
                return redirect('/dashboard');
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
                'pesan' => 'required',
            ], $messages);

            $existingTemplate->update(['pesan' => $request->input('pesan')]);

            flash()
            ->killer(true)
            ->layout('bottomRight')
            ->timeout(3000)
            ->success('<b>Berhasil!</b><br>Template Diperbarui.');

            return redirect('/dashboard')->withInput();
        } else {
            $request->validate([
                'nama_template' => 'required|regex:/^[a-zA-Z0-9]+$/|unique:template',
                'pesan' => 'required',
            ], $messages);

            $data = [   
                'nama_template' => $request->input('nama_template'),
                'pesan' => $request->input('pesan'),
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
