<?php

namespace libbeat;

class NetHandler
{

    private $address;
    private $port;
    private $context_options;
    private $socket;

    /**
     * NetHandler constructor.
     * @param $endpoint
     * @param $port
     * @param null $context_options
     */
    function __construct($endpoint, $port, $context_options = null)
    {
        $this->address = gethostbyname($endpoint);
        $this->port = $port;
        $this->context_options = $context_options;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    function connect()
    {
        $protocol = 'tcp://';
        if (isset($context_options)) {
            $context = stream_context_create($context_options);
            if (array_key_exists('tls', $context_options) || array_key_exists('ssl', $context_options)) {
                $protocol = 'tls://';
            }
        } else {
            $context = stream_context_create();
        }

        $this->socket = stream_socket_client(
            $protocol . $this->address . ':' . $this->port,
            $errno,
            $errstr,
            30,
            STREAM_CLIENT_CONNECT,
            $context
        );
        if (!$this->socket) {
            throw new \Exception("Error stabilising new socket");
        }
        return true;
    }

    function send($payload)
    {
        Logger::debug($payload, true);
        if (FALSE === fwrite($this->socket, $payload, strlen($payload))) {
            $errorcode = socket_last_error($this->socket);
            $errormsg = socket_strerror($errorcode);
            throw new \Exception($errormsg);
        };
    }

    function read()
    {
        $buf = fread($this->socket,1024);
        return $buf;
    }

    function close()
    {
        if (isset($this->socket)) {
            fclose($this->socket);
            unset($this->socket);
        }
    }

    public function __destruct()
    {
        $this->close();
    }


}