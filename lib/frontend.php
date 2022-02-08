<?php

require_once 'classes/Database.php';

$db = new Database();

// Fetch Category
$category = $db->fetchCategory();




?>