<?php

namespace App\Http\Requests\Admin\Promocode;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PromocodeUpdateRequest extends FormRequest
{
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
        return [
            'code' => ['required', 'string', Rule::unique('promocodes', 'code')->whereNot('id', $this->promocode->id)],
            'from_date' => ['required', 'date', 'before_or_equal:to_date'],
            'to_date' => ['required', 'date', 'after_or_equal:from_date'],
            'times' => ['required', 'integer'],
            'percent' => ['required', 'numeric', 'between:1,999999.99'],
        ];
    }
}
