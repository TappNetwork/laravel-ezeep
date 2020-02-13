<?php

Route::post('organization/{organization}', 'WebhookController@registerOrgWebhook');

Route::get('organization/{organization}', 'WebhookController@handleOrgWebhook');
