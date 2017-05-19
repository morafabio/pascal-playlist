<?php

namespace Pascal\Entity;

class Episode
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var Song[]
     */
    protected $songTitles = [];

    /**
     * @param $title
     * @param $url
     */
    public function __construct($title, $url)
    {
        $this->title = $title;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function addSongTitle($title)
    {
        $this->songTitles[] = $title;
    }

    /**
     * @return Song[]
     */
    public function getSongs()
    {
        return $this->songTitles;
    }
}

