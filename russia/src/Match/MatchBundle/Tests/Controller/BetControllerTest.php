<?php

namespace Match\MatchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BetControllerTest extends WebTestCase
{
    public function testMesbets()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/mesBets');
    }

}
