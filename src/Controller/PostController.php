<?php

namespace App\Controller;

use App\Document\Post;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @var DocumentManager
     */
    private $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    #[Route('/post', name: 'post')]
    public function index(): Response
    {
       return new JsonResponse(json_encode($this->documentManager->find(Post::class, 1)));
    }

    #[Route('/post/save', name: 'save')]
    public function save(Request $request): Response
    {
        $post = new Post();
        $resource = $request->getContent();
        $content = json_decode($resource);
        $post->setTitle($content->title);
        $post->setContents($content->content);
        $post->setAuthorId($content->authorId);
        $this->documentManager->persist($post);
        $this->documentManager->flush();
        return new JsonResponse('Success', Response::HTTP_OK);
    }
}
