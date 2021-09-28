<?php

namespace App\Service;

use App\Document\Post;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Request;

class PostService
{
    protected DocumentManager $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    /**
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function savePost(Request $request): Post
    {
        $resource = $request->getContent();
        $content = json_decode($resource);
        $post = new Post(
            $content->title,
            $content->content,
            $content->author_id
        );
        $this->documentManager->persist($post);
        $this->documentManager->flush();
        return $post;
    }

    public function findPost($id): Post
    {
        return $this->documentManager->find(Post::class, $id);
    }
}
