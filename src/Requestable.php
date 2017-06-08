<?php

namespace AfterShip;

interface Requestable
{
    public function send($url, $method, array $data = []);
}