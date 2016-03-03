<?php

// How-To:
// 1. Copy this file in your HTTP server DocumentRoot.
// 2. The webhook link maybe: http://www.example.com/webhook.php, paste in Aftership Dashboard->Settings->Webhook.
// 3. Set the trigger in Webhook setting page, like "In Transit", "Delivered". Aftership will make POST request based on your settings.
// 4. To test your webhook, just click the "Update" button in Webhook Setting page, aftership will send a dummy POST request to your webhook.

// Aftership will make a POST request to your webhook link with 'Content-Type: application/json' header,
// please use the "php://input" to get the post body, body is a JSON String.
// Reference: http://stackoverflow.com/questions/2731297/file-get-contentsphp-input-or-http-raw-post-data-which-one-is-better-to
$inputJSON = file_get_contents("php://input");

// you will get a JOSN string as this api doc mentioned, https://www.aftership.com/docs/api/4/webhook
print_r($inputJSON);

// TO-DO: your logic, your code
