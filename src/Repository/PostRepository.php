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
    private int $pageSize;

    public function __construct(DocumentManager $documentManager, int $pageSize)
    {
        $this->documentManager = $documentManager;
        $this->pageSize = $pageSize;
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

    /**
     * @param array <string> $params
     * @param int $page
     * @return array<Post>|null
     */
    public function findPost(array $params, int $page): ?array
    {
        $repository = $this->documentManager->getRepository(Post::class);
        return $repository->findBy($params, ['authorId' => 'ASC'], $this->pageSize, $page * $this->pageSize);
    }
}
