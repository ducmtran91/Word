<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\TypeWord;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Vocabulary;

class VocabularyPostRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'word' => 'required|max:255|unique:vocabularies,word,'.$this->vocabulary->id,
            'pronounce' => 'required|max:255|unique:vocabularies,pronounce,'.$this->vocabulary->id,
            'description' => 'required',
            'example' => 'required',
            'type' => ['required', new EnumValue(TypeWord::class)],
        ];
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                $rules = [];
            }
            case 'POST':
            {
                $rules['image'] = 'required|image|max:2048';
            }
            case 'PUT':
            case 'PATCH':
            {

                if ($this->file('image')) {
                    $rules['image'] = 'required|image|max:2048';
                }
            }
            default:
                break;
        }
        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'word.required' => 'A :attribute is required'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'word' => 'Word',
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));

    }
}
