#!/usr/bin/php
<?php

require __DIR__ . '/../vendor/autoload.php';

$config = \Symfony\Component\Yaml\Yaml::parse(file_get_contents(__DIR__ . '/../config/config.yml'));
$session = new SpotifyWebAPI\Session($config['spotify']['client_id'], $config['spotify']['client_secret'], $config['spotify']['callback_url']);
$options = [ 'scope' => [ 'playlist-modify-public', 'playlist-modify-private' ] ];
$api = new SpotifyWebAPI\SpotifyWebAPI();

$csvFilename = './2015-16.csv';
$spotifyUser = 'fabio.mm';
$playlistId = '5fYWEdPhqk6h4qjaVIJZcg'; // 2015
$playlistId = '0QIxP6uJrIfsuR10xbRgKT'; // 2016

//var_dump($session->getAuthorizeUrl($options)); die;
//$session->requestAccessToken('');
//var_dump($session->getAccessToken()); die;

$api->setAccessToken($config['spotify']['access_token']);

$csvFp = fopen($csvFilename, 'r');
$missings = [];

while ($line = fgetcsv($csvFp))
{
    if ($line[1] == $line[2]) {
        $title = $line[1];
    } else {
        $title = sprintf('%s %s', $line[1], $line[2]);
    }
    $title = str_replace(['Playlist:', '/'], [' ', ''], $title);
    $title = preg_replace("/[^A-Za-z0-9 ]/", '', $title);
    print $title;

    $results = $api->search($title, 'track', ['limit' => 1]);

    if (isset($results->tracks->items) && (count($results->tracks->items) == 1))
    {
        $track = $results->tracks->items[0];
        $api->addUserPlaylistTracks($spotifyUser, $playlistId, [$track->uri]); // 2015
        printf (" (%s)", $track->uri);
    } else {
        $missings[] = $title;
    }

    print "\n";
}

print_r($missings);
