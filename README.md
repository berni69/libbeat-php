# libbeat-php
Use this library to build a beats in PHP, implements lumberjeck 2 protocol. Supports compression and TLS

## How to use? 

To use this library you only need to add it to your composer file running: 

```
composer require berni69/libbeat
```

Once installed, you can send a "beat" as follows:

```php
<?php
require __DIR__.'/vendor/autoload.php';

use libbeat\BeatSender;
$beat = new  BeatSender('192.168.26.12', 5044);
$beat->send("test_log");
$beat->set_compression_rate(0);
$beat->send(["test_log2", "test_log3"]);
```

To use TLS/SSL you must pass the context options (http://php.net/manual/en/context.ssl.php) to the BeatSender constructor as follows:

```php
<?php
$options = array(
             "ssl" => array(
                 "local_cert"        => $MYCERT,
                 /* If the certificate we are providing was passphrase encoded, we need to set it here */
                 "passphrase"        => "My Passphrase for the local_cert",
         
                 /* Optionally verify the server is who he says he is */
                 "cafile"            => $SSL_DIR . "/" . $SSL_FILE,
                 "allow_self_signed" => false,
                 "verify_peer"       => true,
                 "verify_peer_name"  => true,
                 "verify_expiry"     => true,
             ));
$beat = new  BeatSender('192.168.26.12', 5044, $options);
```