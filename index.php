<?php
include './app/app.php';

use app\rest\contactsApi;

try {
    $api = new contactsApi();
    $contacts = $api->run();
    echo $contacts;
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}
