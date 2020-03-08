<?php

session_start();

use handlers\ContentHandler;

define("ROOT", __DIR__ . DIRECTORY_SEPARATOR);

define('URL_PUBLIC_FOLDER', 'public');			// De public folder is de folder waar alle bestanden in staan die via de adresbalk direct aangevraagd kunnen worden, denk aan CSS, JS, afbeeldingen etc...
define('URL_PROTOCOL', '//');					// Het URL protocol bepaalt of een site via HTTP of HTTPS wordt opgevraagd. Bij '//' wordt de gebruikte methode gebruikt
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);	// Dit bepaald de URL van de website
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME']))); // Dit bepaalt de subfolder van de website. Bijvoorbeeld of jij de website op: 127.0.0.1/webapp hebt draaien.
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER); // Dit genereerd de standaard URL van de applicatie

require_once(ROOT . "handlers/ContentHandler.php");

if (isset($_GET["redirect"]))  ContentHandler::getInstance()->route($_GET["redirect"]);
else ContentHandler::getInstance()->route("");
?>

