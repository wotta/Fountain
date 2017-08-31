<?php

namespace App\Http\Requests\Fountain\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateStripePlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() && $this->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required|max:255',
            'amount'            => 'required|numeric|min:0|max:1000000',
            'interval'          => 'required',
            'interval_count'    => 'required|numeric|min:0',
            'trial_period_days' => 'required|numeric|min:0',
        ];
    }
}
