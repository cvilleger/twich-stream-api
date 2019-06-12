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
    private $twitchFamily;
    private $cache;

    public function __construct(CacheInterface $cache, HttpClientInterface $twitchClient, string $twitchClientId, string $twitchFamily)
    {
        $this->cache = $cache;
        $this->twitchClient = $twitchClient;
        $this->twitchClientId = $twitchClientId;
        $this->twitchFamily = $twitchFamily;

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
            $item->expiresAfter(60);
            return $this->getReponses();
        });

        $io->success('Success');
    }

    private function getReponses(): array
    {
        $options = [
            'headers' => [
                'Client-ID' => $this->twitchClientId,
                'Accept' => 'application/vnd.twitchtv.v5+json',
            ],
        ];

        $url = sprintf('kraken/teams/%s', $this->twitchFamily);
        $responseTeam = $this->twitchClient->request('GET', $url, $options)->toArray();

        $url = 'helix/streams?';
        foreach ($responseTeam['users'] as $user){
            $url .= sprintf('user_login=%s&', $user['name']);
        }

        $options = [
            'headers' => [
                'Client-ID' => $this->twitchClientId,
            ],
        ];

        //TODO Refacto
        $responseStreams = $this->twitchClient->request('GET', $url, $options)->toArray()['data'];

        return $responseStreams;
    }
}
