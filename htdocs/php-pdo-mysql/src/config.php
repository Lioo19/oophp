<?php
/**
 * Set the error reporting.
 */
error_reporting(-1);              // Report all type of errors
ini_set("display_errors", 1);     // Display all errors



/**
 * Default exception handler.
 */
set_exception_handler(function ($e) {
    echo "Uncaught exception: <p>"
        . $e->getMessage()
        . "</p><p>Code: "
        . $e->getCode()
        . "</p><pre>"
        . $e->getTraceAsString()
        . "</pre>";
});



/**
 * Details for connecting to the database.
 */
$databaseConfig = [
    "dsn"      => "mysql:host=127.0.0.1;dbname=oophp;",
    "login"    => "user",
    "password" => "pass",
    "options"  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
];
