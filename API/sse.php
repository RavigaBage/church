<?php
session_start();
require ('Assets&projects/autoloader.php');
require __DIR__ . '/vendor/autoload.php';

use Hhxsv5\SSE\Event;
use Hhxsv5\SSE\SSE;
use Hhxsv5\SSE\StopSSEException;

// PHP-FPM SSE Example: push messages to client

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no'); // Nginx: unbuffered responses suitable for Comet and HTTP streaming applications

if (isset($_GET['Data'])) {
    $Newcallback = function () {
        $id = mt_rand(1, 1000);
        $newData = new viewData();
        $news = $newData->LastModified(); // Get news from database or service.

        if ($news == false) {
            return false; // Return false if no new messages
        }
        $shouldStop = false; // Stop if something happens or to clear connection, browser will retry
        if ($shouldStop) {
            throw new StopSSEException();
        }
        return json_encode(compact('news'));
        // return ['event' => 'ping', 'data' => 'ping data']; // Custom event temporarily: send ping event
        // return ['id' => uniqid(), 'data' => json_encode(compact('news'))]; // Custom event Id
    };
    (new SSE(new Event($Newcallback, 'news')))->start();
}





