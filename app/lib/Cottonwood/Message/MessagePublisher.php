<?php

namespace Cottonwood\Message;

interface MessagePublisher
{
    public function send($room, $evt, $data);
}