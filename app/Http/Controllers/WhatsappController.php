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


class GajiController extends Controller
{
    public function whatsapp(Request $request)
    {
        

        $whatsapp_cloud_api = new WhatsAppCloudApi([
            'from_phone_number_id' => '386632231198502',
            'access_token' => 'EAAL8DfhS4ZBgBO0WLNblWiBqq6dfyc9y5nX15LMB5NCJ4BVNpglCayHXO6uOQlzp2KqKOtNlySs1WTl48hMU89n6eXqPcMZAxvZBwBZAlGxtMACtzCJ3omXsqxPPKnhM0hZAmWJlPXijBK5J2EuLCCTfIGrN8i4jbZCZAkpcSqGyyF3RngZB6Vr30IquDI2P49LZAYp9XFZBnXQPf5wIaoDkotopF6G1psHLAGZC3Wq',
            'graph_version' => 'v20.0'
        ]);
        
        $whatsapp_cloud_api->sendTextMessage('6282119757291', 'Hey there! I\'m using WhatsApp Cloud API. Visit https://www.netflie.es');


        return redirect('/dashboard');
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
