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
        if(is_null($plan = Plan::find($this->plan_id)))
            app()->abort(422, 'No such a plan');

        if(!$this->user()->allowDeposit())
            app()->abort(422, 'Wait until your current deposit expire.');


        return [
            'plan_id' => 'required',
            'amount' => 'required|numeric|min:' . $plan->min_deposit . '|max:' . $plan->max_deposit,
        ];
    }
}
