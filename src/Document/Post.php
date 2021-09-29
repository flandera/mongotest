<?php

declare(strict_types=1);

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JsonSerializable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

/** @MongoDB\Document */
class Post extends Entity implements JsonSerializable
{
    public function __construct(string $title, string $contents, int $authorId)
    {
        parent::__construct();

        $this->title = $title;
        $this->contents = $contents;
        $this->authorId = $authorId;
    }
    /** @MongoDB\Field(type="string") */
    protected string $title;

    /** @MongoDB\Id */
    protected string $id;

    /** @MongoDB\Field(type="string") */
    protected string $contents;

    /** @MongoDB\Field(type="int") */
    protected int $authorId;

    public function getId(): string
    {
        return $this->id;
    }

    public function jsonSerialize(): object
    {
        return (object) get_object_vars($this);
    }
}
