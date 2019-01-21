<?php
require __DIR__.'/vendor/autoload.php';

use libbeat\BeatSender;
$beat = new  BeatSender('192.168.26.12', 5044);
$beat->send("test_log");
$beat->set_compression_rate(0);
$beat->send(["test_log2", "test_log3"]);


