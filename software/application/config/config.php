<?php

/**
 * Configurazione
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 */

/**
 * Configurazione di : Error reporting
 * Utile per vedere tutti i piccoli problemi in fase di sviluppo, in produzione solo quelli gravi
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Configurazione di : URL del progetto
 */
define('URL', 'https://www.gestione-lavoro.com/');

define("DB_HOST", "127.0.0.1");
define("DB_PORT", 3306);
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "gestione_lavoro");


