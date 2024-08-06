<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\template;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use Netflie\WhatsAppCloudApi\Message\Media\LinkID;
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
        $request->validate([
            // 'template' => 'required|string',
            'pesan' => 'required',
            'file' => 'nullable|file'
        ]);

        // $template = $request->input('template');
        $pesan = $request->input('pesan');
        

        $to = '6282119757291'; // Nomor tujuan harus diisi dengan benar

        // Mengirim pesan teks
        $this->whatsapp->sendTextMessage($to, $pesan);

         // Jika ada file yang di-upload
        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment')->path();
            $mediaId = $this->whatsapp->uploadMedia($attachment);

            // Mengirim pesan media berdasarkan tipe file
            $this->whatsapp->sendDocument($to, $mediaId, $attachment->getClientOriginalName());
        }
        
        return redirect('/dashboard')->with('success','pesan berhasil dikirim!');
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
        ->success('<b>Berhasil!</b><br>Template Sudah Dihapus.');
        
        return redirect('/dashboard');
    }
}
