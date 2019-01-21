<?php
/**
 * Created by PhpStorm.
 * User: berni
 * Date: 21/01/2019
 * Time: 11:34
 */

namespace libbeat\Frames;


class CompressedFrame extends BeatFrame
{

    public function __construct($arg = null, $compression_level = 3)
    {
        if (!is_null($arg)) {
            $gz = gzencode($arg, $compression_level,FORCE_DEFLATE);
            $this->setPayload(strlen($gz), $gz);
        }
        $this->setVersion(BeatFrame::v2);
        $this->setFrameType(FrameType::COMPRESSED);
    }

    public function setPayload(int $payload_lenght, $payload = null)
    {
        $this->payload = pack('NC*', $payload_lenght) . $payload;
    }
}