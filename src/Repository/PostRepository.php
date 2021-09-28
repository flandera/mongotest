<?php
declare(strict_types=1);

namespace App\Repository;

use App\Document\Post;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Symfony\Component\HttpFoundation\Request;

class PostRepository
{
    protected DocumentManager $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    /**
     * @throws MongoDBException
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

    public function findPost($id): ?Post
    {
        return $this->documentManager->find(Post::class, $id);
    }
}
