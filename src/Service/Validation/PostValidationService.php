<?php

declare(strict_types=1);

namespace App\Service\Validation;

use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class PostValidationService
{
    /**
     * @throws ValidationException
     */
    public function validateSavePost(Request $request): ?bool
    {
        $constraints = new Collection([
            'title' => (new Required([new NotBlank(), new Assert\Type(['type' => 'string'])])),
            'content' => (new Required([new NotBlank(), new Assert\Type(['type' => 'string'])])),
            'author_id' => (new Required([new NotBlank(), new Regex([
                    'pattern' => "/^[0-9]+$/"
            ])])),
        ]);
        $validator = Validation::createValidator();
        $validation = $validator->validate(json_decode($request->getContent(), true), $constraints);
        if (count($validation) > 0) {
            $errorsString = (string) $validation;
            throw new ValidationException($errorsString);
        }
        return true;
    }
}
