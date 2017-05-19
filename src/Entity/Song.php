<?php

namespace Pascal\Entity;

class Song
{
    protected $title;

    protected $author;

    /**
     * @param $title
     * @param $author
     */
    public function __construct($title, $author)
    {
        $this->title = $title;
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
