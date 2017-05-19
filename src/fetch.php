#!/usr/bin/php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Goutte\Client;
use Pascal\Entity\Episode;
use Pascal\Entity\Season;
use Pascal\Entity\Song;

$csvFilename = './data.csv';
$categoryUrl = 'http://pascal.blog.rai.it/category/puntate/page/%d/';
$pages = range(1, 39);

$client = new Client();
$csvFp = fopen($csvFilename, 'w');

$season = new Season();

foreach ($pages as $page)
{
    $url = sprintf($categoryUrl, $page);
    printf($url . "\n");

    $crawler = $client->request('GET', $url);

    $crawler->filter('h2.post-title')->each(function ($node) use ($season) {
        $episode = new Episode($node->text(), $node->filter('a')->attr('href'));
        $season->addEpisode($episode);
    });
}

foreach ($season->getEpisodes() as $episode)
{
    $crawler = $client->request('GET', $episode->getUrl());
    printf("\t > " . $episode->getUrl() . "\n");

    $crawler->filter('article p')->each(function ($node) use ($episode) {
        $matches = [];
        if (strlen($node->text()) > 150 || strlen($node->text()) < 6) { return; }
        if (!preg_match('/^\s*(.*)\s[-–]{1,}\s(.*)\s*/i', $node->text(), $matches)) { return; }

        $episode->addSongTitle(new Song($matches[1], $matches[2]));
    });
}

fputcsv($csvFp, ['episode', 'author', 'title']);

foreach ($season->getEpisodes() as $episode) {
    foreach ($episode->getSongs() as $song) {
        fputcsv($csvFp, [ $episode->getTitle(), $song->getAuthor(), $song->getTitle() ]);
    }
}

fclose($csvFp);
