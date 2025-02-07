<?php

namespace App\Data;

use App\Models\Submission;
use Spatie\LaravelData\Data;

class SubmissionData extends Data
{
    public function __construct(
        readonly string $name,
        readonly string $email,
        readonly string $phone,
        readonly string $message,
        readonly string $street,
        readonly string $state,
        readonly string $zip,
        readonly string $country,
        readonly ?array $images = null,
        readonly ?array $files = null
    ) {
    }

    public function toModel(null|int|Submission $submission = null): Submission
    {
        if (is_int($submission)) {
            $submission = Submission::query()->find($submission);
        }

        $submission ??= new Submission();

        $submission->fill($this->all());

        return $submission;
    }
}

