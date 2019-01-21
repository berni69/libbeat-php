# libbeat-php
Use this library to build a beats in PHP, implements lumberjeck 2 protocol. Supports compression and TLS

## How to use? 

```
<?php
require __DIR__.'/vendor/autoload.php';

use libbeat\BeatSender;
$beat = new  BeatSender('192.168.26.12', 5044);
$beat->send("test_log");
$beat->set_compression_rate(0);
$beat->send(["test_log2", "test_log3"]);
```

