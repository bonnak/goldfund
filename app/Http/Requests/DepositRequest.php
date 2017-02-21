<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Plan;

class DepositRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $plan = Plan::find($this->plan_id);

        return [
            'plan_id' => 'required',
            'amount' => 'required|numeric|min:' . $plan->min_cost . '|max:' . $plan->max_cost,
            //'invoice_attachment' => 'required|file'
        ];
    }
}
