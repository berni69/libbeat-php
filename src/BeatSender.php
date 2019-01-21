<?php

namespace libbeat;

use libbeat\Frames\AckFrame;
use libbeat\Frames\CompressedFrame;
use libbeat\Frames\JsonFrame;
use libbeat\Frames\WindowFrame;
use libbeat\Message\BeatMessage;


class BeatSender
{
    const version = '0.0.1';

    private $socket;
    private $seq;
    private $compression;

    function __construct($endpoint, $port, $net_handler_options = null)
    {
        $this->socket = new NetHandler($endpoint, $port, $net_handler_options);
        $this->socket->connect();
        $this->compression = 3;
        $this->seq = 257;
    }

    public function send($msg)
    {
        if (is_string($msg)) {
            $msg = [$msg];
        }

        $buff = '';
        foreach ($msg as $m) {
            $frame = new JsonFrame();
            $payload = (string)(new BeatMessage($m));
            $frame->setPayload($this->seq, $payload);
            $buff = $buff . $frame->getFrame();
            $this->seq++;
        }
        if ($this->compression > 0) {
            $c = new CompressedFrame($buff);
            $buff = $c->getFrame();
        }
        $w = new WindowFrame(count($msg));
        $this->socket->send($w->getFrame() . $buff);
        $r = $this->socket->read();
        $ack = new AckFrame($r);
        if ($this->seq - 1 != $ack->get_ack_id()) {
            throw new \Exception("Some problem ocurred sending the message", $ack->get_ack_id());
        }
    }

    public function set_compression_rate($compression)
    {
        $this->compression = $compression;
    }

    public function __destruct()
    {
        $this->socket->close();
    }

}