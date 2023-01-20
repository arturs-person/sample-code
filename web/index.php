<?php
require './vendor/autoload.php';

use App\App;
use App\Router;
use App\Middleware\Session;
const TEMPLATE_PATH = __DIR__ . '/app/Templates';
const STORAGE_PATH = __DIR__ . '/storage';

//$client = new GuzzleHttp\Client();
//
//$res = $client->request('GET', 'https://catfact.ninja/fact');
//header('Content-Type: application/json');
//
//$dbh = new PDO('mysql:host=database;dbname=database', 'user', 'pass');
//$dbh = null;
//echo $res->getBody();
(new App(
    new Router([new Session()])
))->run();