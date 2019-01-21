<?php
/**
 * Created by PhpStorm.
 * User: berni
 * Date: 21/01/2019
 * Time: 11:17
 */

namespace libbeat\Frames;


class JsonFrame extends BeatFrame
{

    public function __construct($arg = null)
    {
        $this->setVersion(BeatFrame::v2);
        $this->setFrameType(FrameType::JSON);
        parent::__construct($arg);
    }


    public function setPayload(int $seq, $payload)
    {

        //$json = json_encode($payload);
        $this->payload = pack('NNC*', $seq, strlen($payload)) . $payload;

    }
}