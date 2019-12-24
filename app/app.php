<?php
require $_SERVER['DOCUMENT_ROOT'].'/app/db/connect.php';
require $_SERVER['DOCUMENT_ROOT'].'/app/rest/api.php';

$db = \app\db\DbConnect::getInstance();

require $_SERVER['DOCUMENT_ROOT'].'/app/rest/contactsApi.php';
