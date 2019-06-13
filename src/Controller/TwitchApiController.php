<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Contracts\Cache\CacheInterface;

class TwitchApiController extends AbstractFOSRestController
{
    private $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function getApiTwitchAction()
    {
        return $this->json($this->cache->get('twitch.responses', function (){}));
    }
}
