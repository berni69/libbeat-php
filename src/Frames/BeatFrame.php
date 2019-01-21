<?php

namespace libbeat\Frames;

abstract class BeatFrame
{
    /*      0                   1                   2                   3
          0 1 2 3 4 5 6 7 8 9 0 1 2 3 4 5 6 7 8 9 0 1 2 3 4 5 6 7 8 9 0 1
         +---------------+---------------+-------------------------------+
         |   version(1)  |   frame type  |     payload ...               |
         +---------------------------------------------------------------+
         |   payload continued...                                        |
         +---------------------------------------------------------------+
    */

    const v1 = 0x31;
    const v2 = 0x32;

    protected $version;
    protected $frame_type;
    protected $payload;

    public function __construct($frame = null)
    {
        if (isset($frame)) {
            $this->version = $frame[0];
            $this->frame_type = $frame[1];
            $this->payload = substr($frame, 2);
        }
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getFrameType()
    {
        return $this->frame_type;
    }

    public function setFrameType(int $frame_type)
    {
        $this->frame_type = $frame_type;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    abstract public function setPayload(int $seq, $payload);

    public function getFrame()
    {
        return pack('CCC*', $this->version, $this->frame_type). $this->payload;

    }


}