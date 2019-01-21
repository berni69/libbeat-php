<?php

namespace libbeat\Frames;

class AckFrame extends BeatFrame
{
    public function __construct($arg = null)
    {
        if (is_int($arg)) {
            $this->setPayload($arg);
        } else {
            parent::__construct($arg);
        }
        $this->setVersion(BeatFrame::v2);
        $this->setFrameType(FrameType::ACK);
    }

    public function setPayload(int $ack_seq, $payload = null)
    {
        $this->payload = pack('NC*', $ack_seq);
    }

    public function get_ack_id()
    {
        return unpack('N*', $this->getPayload())[1];
    }

}