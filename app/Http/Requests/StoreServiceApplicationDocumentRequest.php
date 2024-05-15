<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceApplicationDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title_document.*' => 'required|string|max:255',
            'title_document_file.*' => 'required|mimes:jpeg,jpg,png,pdf,doc,docx', // Use 'title_document_file.*' for array validation
        ];
    }
}
