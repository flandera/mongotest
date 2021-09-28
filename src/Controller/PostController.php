<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\PostService;
use App\Service\Validation\PostValidationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    private PostValidationService $postValidationService;
    private PostService $postService;
    public function __construct(PostValidationService $postValidationService, PostService $postService)
    {
        $this->postValidationService = $postValidationService;
        $this->postService = $postService;
    }

    #[Route('/post/{id}', name: 'get_post')]
    public function show(Request $request): Response
    {
        $id = $request->get('id');
        try {
            $post = $this->postService->findPost($id);
        } catch (\Exception $e) {
            return new JsonResponse('Error find post', 404);
        }
        return new JsonResponse($post, 200);
    }

    #[Route('/post/save', name: 'save')]
    public function save(Request $request): Response
    {
        try {
            $this->postValidationService->validateSavePost($request);
        } catch (\Exception $e) {
            return new JsonResponse('Validation error:' . $e->getMessage(), 400);
        }
        try {
            $post = $this->postService->savePost($request);
        } catch (\Exception $e) {
            return new JsonResponse('Error while saving entity: ' . $e->getMessage(), 403);
        }
        return new JsonResponse('Post id: ' . $post->getId(), Response::HTTP_OK);
    }
}
