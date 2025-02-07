<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubmissionRequest;
use App\Service\SubmissionService;
use Illuminate\Http\JsonResponse;

class SubmissionController extends Controller
{
    public function __construct(protected SubmissionService $service)
    {
    }

    public function store(CreateSubmissionRequest $request): JsonResponse
    {
        $this->service->create($request->dataObject());

        return response()->json(['status' => 'success']);
    }
}
