<?php

namespace College\Ddcollege\Route;

namespace College\Ddcollege\Controller;
require __DIR__ . '/../vendor/autoload.php';


session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Check if the current page is not the login page to avoid a loop
    if (basename($_SERVER['REQUEST_URI']) !== 'login') {
        // Redirect to the login page
        header("Location: ../login");
        exit();
    }
}

// Login handler for redirecting to index.php if the user is logged in and accessing the login page
if (isset($_SESSION['username']) && basename($_SERVER['REQUEST_URI']) === 'login') {
    // Redirect to the home page (index.php)
    header("Location: /");
    exit();
} else if (isset($_POST["logout"])) {
    $logoutcontroller = new Logincontroller();
    $logoutdatareceived = $logoutcontroller->logout();
    exit();
}