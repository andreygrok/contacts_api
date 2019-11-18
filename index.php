<?php
include './app/app.php';
try {
    $api = new \app\rest\contactsApi();
    $contacts = $api->run();
    echo $contacts;
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}
