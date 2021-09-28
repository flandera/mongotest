<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

/**
 * @MongoDB\Document
 */
class Post extends Entity
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $title;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $contents;

    /**
     * @MongoDB\Field(type="int")
     */
    protected $authorId;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Post
     */
    public function setTitle(string $title): Post
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getContents(): string
    {
        return $this->contents;
    }

    /**
     * @param string $contents
     * @return Post
     */
    public function setContents(string $contents): Post
    {
        $this->contents = $contents;
        return $this;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @param mixed $authorId
     * @return Post
     */
    public function setAuthorId($authorId): Post
    {
        $this->authorId = $authorId;
        return $this;
    }

}