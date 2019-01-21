<?php
/**
 * Created by PhpStorm.
 * User: berni
 * Date: 21/01/2019
 * Time: 11:34
 */

namespace libbeat\Frames;


class WindowFrame extends BeatFrame
{

    public function __construct($arg = null)
    {
        if (is_int($arg)) {
            $this->setPayload($arg);
        } else {
            parent::__construct($arg);
        }
        $this->setVersion(BeatFrame::v2);
        $this->setFrameType(FrameType::WINDOW_SIZE);
    }

    public function setPayload(int $window_lenght, $payload = null)
    {
        $this->payload = pack('NC*', $window_lenght);
    }
}