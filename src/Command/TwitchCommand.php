<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TwitchCommand extends Command
{
    protected static $defaultName = 'app:twitch';

    private $twitchClient;
    private $twitchClientId;
    private $twitchLogins;
    private $cache;

    public function __construct(CacheInterface $cache, HttpClientInterface $twitchClient, string $twitchClientId, string $twitchLogins)
    {
        $this->cache = $cache;
        $this->twitchClient = $twitchClient;
        $this->twitchClientId = $twitchClientId;
        $this->twitchLogins = $twitchLogins;

        Command::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Refresh Twitch data cache');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->cache->delete('twitch.responses');
        $this->cache->get('twitch.responses', function (ItemInterface $item) {
            return $this->getReponses();
        });

        $io->success('Success');
    }

    private function getReponses(): array
    {
        $options = [
            'headers' => [
                'Client-ID' => $this->twitchClientId,
            ],
        ];

        $responses = [];
        $twitchLogins = explode(',', $this->twitchLogins);
        foreach ($twitchLogins as $twitchLogin) {
            $url = sprintf('/helix/streams?user_login=%s', $twitchLogin);
            $response = $this->twitchClient->request('GET', $url, $options)->toArray();

            if (isset($response['data'][0])){
                $responses[$twitchLogin] = $response['data'][0];
            }
        }

        return $responses;
    }
}
