#!/usr/bin/php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Goutte\Client;

$client = new Client();

$categoryUrl = 'http://pascal.blog.rai.it/category/puntate/page/%d/';
$pages = range(1, 2);

class Episode
{
    public $title, $url;

    public function __construct($title, $url)
    {
        $this->title = $title;
        $this->url = $url;
    }

}

$episodes = [];

foreach ($pages as $page)
{
    $url = sprintf($categoryUrl, $page);
    printf($url . "\n");

    $crawler = $client->request('GET', $url);

    $crawler->filter('h2.post-title')->each(function ($node) use (&$episodes) {
        printf("%s, %s\n", $node->text(), $node->filter('a')->attr('href'));
        $episode = new Episode($node->text(), $node->filter('a')->attr('href'));
        $episodes[] = $episode;
    });
}

var_dump($episodes);