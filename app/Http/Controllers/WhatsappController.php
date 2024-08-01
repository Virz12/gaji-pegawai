<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $file = $request->file('file');

        $to = '6282119757291'; // Nomor tujuan harus diisi dengan benar

        // Mengirim pesan teks
        $this->whatsapp->sendTextMessage($to, $pesan);

         // Jika ada file yang di-upload
        if ($file) {
            $mimeType = $file->getClientMimeType();
            $mediaId = $this->whatsapp->uploadMedia($file_path, $mimeType);

            // Mengirim pesan media berdasarkan tipe file
            if (strpos($mimeType, 'image') !== false) {
                $this->whatsapp->sendImage($to, $mediaId, $file->getClientOriginalName());
            } elseif (strpos($mimeType, 'application') !== false) {
                $this->whatsapp->sendDocument($to, $mediaId, $file->getClientOriginalName());
            } else {
                // Penanganan untuk tipe file lainnya jika diperlukan
            }
        }
        return redirect('/dashboard')->with('success','pesan berhasil dikirim!');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
