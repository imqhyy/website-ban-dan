<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../../forms/database.php";
include __DIR__ . "/head.php";
