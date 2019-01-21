<?php

namespace libbeat\Message;

use libbeat\BeatSender;

class BeatMessage
{
    private $timestamp;
    private $os;
    private $prospector;
    private $input;
    private $beat_name;
    private $message;
    private $hostname;

    public function __construct($message, $timestamp = null, $beat_name = 'phpbeat', $prospector = 'log', $input = 'log')
    {
        if (is_null($timestamp)) {
            $this->timestamp = $this->formatted_timestamp();
        }
        $this->hostname = gethostname();
        $this->os = $this->get_os_info();
        $this->message = $message;
        $this->metadata = $this->get_metadata();
        $this->beat_name = $beat_name;
        $this->prospector = $prospector;
        $this->input = $input;
    }


    private function get_os_info()
    {

        $arch = $_SERVER['PROCESSOR_ARCHITEW6432'];
        $os = $_SERVER['OS'];
        return ['name' => $this->hostname, 'architecture' => $arch, 'os' => ['family' => $os, 'platform' => $os], /*'php' => PHP_VERSION*/];

    }

    private function get_metadata()
    {
        return ['beat' => $this->beat_name, 'type' => 'doc', 'version' => BeatSender::version];

    }

    private function get_beat()
    {
        return ['name' => $this->hostname, 'hostname' => $this->hostname, 'version' => BeatSender::version];
    }

    private function formatted_timestamp()
    {
        return gmdate('Y-m-d\TH:i:s\Z', time());
    }

    public function __toString()
    {
        return json_encode(['@timestamp' => $this->timestamp, '@metadata' => $this->get_metadata(),
            'host' => $this->get_os_info(), 'message' => $this->message, 'source' => '', 'offset' => 0,
            'prospector' => ['type' => $this->prospector], 'input' => ['type' => $this->input],
            'beat' => $this->get_beat()]);
    }

}