<?php

namespace Pascal\Entity;

class Season
{
    /**
     * @var Episode[]
     */
    protected $episodes = [];

    /**
     * @return Episode[]
     */
    public function getEpisodes()
    {
        return $this->episodes;
    }

    /**
     * @param $episodes
     */
    public function addEpisode(Episode $episodes)
    {
        $this->episodes[] = $episodes;
    }
}