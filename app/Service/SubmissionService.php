<?php

namespace App\Service;

use App\Data\SubmissionData;
use App\Models\Submission;

class SubmissionService
{

    public function create(SubmissionData $data): Submission
    {
        $submission = $data->toModel();

        $submission->save();

        return $submission;
    }
}
