<?php

namespace libbeat\Frames;

abstract class FrameType
{
    const DATA = 0x44;
    const JSON = 0x4a;
    const ACK = 0x41;
    const WINDOW_SIZE = 0x57;
    const COMPRESSED = 0x43;

}