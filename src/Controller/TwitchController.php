<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Contracts\Cache\CacheInterface;

class TwitchController extends AbstractFOSRestController
{
    private $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function getTwitchAction()
    {
        return $this->json($this->cache->get('twitch.responses', function (){}));
    }
}
