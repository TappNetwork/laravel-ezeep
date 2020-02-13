<?php

namespace Tapp\Ezeep\Http\Controllers;

use Ezeep;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WebhookController extends Controller
{
    public function handleOrganizationWebhook(Request $request)
    {
        \Log::info($request->all());
    }
}
