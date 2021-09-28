<?php

namespace App\Tests;

use App\Controller\PostController;
use App\Exception\ValidationException;
use App\Service\Validation\PostValidationService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class ValidationServiceTest extends TestCase
{
    private string $data;
    private string $failData1;
    private string $failData2;
    private string $failData3;
    private string $failData4;

    public function setUp(): void
    {
        $this->data = '{
                   "title": "test1",
                   "content": "neco neco",
                   "author_id": 21
                }';
        $this->failData1 = '{
                   "content": "neco neco",
                   "author_id": 21
                }';
        $this->failData2 = '{
                    "title": "test1",
                   "author_id": 21
                }';
        $this->failData3 = '{
                   "title": "test1",
                   "content": "neco neco"
                }';
        $this->failData4 = '{
                  "title": "test1",
                   "content": "neco neco",
                   "author_id": "aa"
                }';
    }

    /**
     * @throws ValidationException
     */
    public function testValidation(): void
    {
        $service = new PostValidationService();
        $request = new Request([], [], [], [], [], [], $this->data);
        $this->assertSame(true, $service->validateSavePost($request));
    }

    public function testMissingFieldTitleValidation(): void
    {
        $service = new PostValidationService();
        $request = new Request([], [], [], [], [], [], $this->failData1);
        $this->expectException(ValidationException::class);
        $service->validateSavePost($request);
    }

    public function testMissingFieldContentValidation(): void
    {
        $service = new PostValidationService();
        $request = new Request([], [], [], [], [], [], $this->failData2);
        $this->expectException(ValidationException::class);
        $service->validateSavePost($request);
    }

    public function testMissingFieldAuthorIdValidation(): void
    {
        $service = new PostValidationService();
        $request = new Request([], [], [], [], [], [], $this->failData3);
        $this->expectException(ValidationException::class);
        $service->validateSavePost($request);
    }

    public function testwrongTypeFieldAuthorIdValidation(): void
    {
        $service = new PostValidationService();
        $request = new Request([], [], [], [], [], [], $this->failData4);
        $this->expectException(ValidationException::class);
        $service->validateSavePost($request);
    }
}
