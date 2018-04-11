<?php

namespace Match\MatchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PartieControllerTest extends WebTestCase
{
    public function testListmatch()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/listMatch');
    }

}
