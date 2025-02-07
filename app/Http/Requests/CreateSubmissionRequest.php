<?php

namespace App\Http\Requests;

use App\Data\SubmissionData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class CreateSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => [
                'required',
                'string',
            ],
            'email'    => [
                'required',
                'email',
            ],
            'phone'    => [
                'required',
                'string',
                'regex:/^(\+\d{1,2}\s?)?(\(?\d{3}\)?[\s\-]?)?[\d\s\-]{7,10}$/',
            ],
            'message'  => [
                'required',
                'string',
                'min:20',
            ],
            'street'   => [
                'required',
                'string',
            ],
            'state'    => [
                'required',
                'string',
            ],
            'zip'      => [
                'required',
                'numeric',
            ],
            'country'  => [
                'required',
                'string',
            ],
            'images'   => [
                'nullable',
                'array',
            ],
            'images.*' => [
                'nullable',
                'file',
                'mimes:jpeg,jpg',
                'max:10240',
            ],
            'files'    => [
                'nullable',
                'array',
            ],
            'files.*'  => [
                'nullable',
                'file',
                'mimes:pdf',
                'max:10240',
            ],
        ];
    }

    public function dataObject(): SubmissionData
    {
        $validatedData = $this->validated();

        $validatedData['images'] = $this->hasFile('images') ?
                $this->uploadFiles($validatedData['images']) : null;

        $validatedData['files'] = $this->hasFile('files') ?
            $this->uploadFiles($validatedData['files']) : null;

        return SubmissionData::from($validatedData);
    }

    protected function uploadFiles(array $files): array
    {
        return array_map(
            fn (UploadedFile $file) => $file->store('files', 'files'),
            $files
        );
    }
}
