<?php
namespace Controller;

use Core\Response;
use Core\Request;

final class PingApiController
{
    public function ping(Request $request, Response $response)
    {
        $response->json(['ok' => true, 'message' => 'pong']);
    }
}