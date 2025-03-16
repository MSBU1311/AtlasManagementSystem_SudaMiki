<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class RegisterRequest extends FormRequest
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
            'over_name' => ['required', 'string', 'max:10'],
            'under_name' => ['required', 'string', 'max:10'],
            'over_name_kana' => ['required', 'string', 'max:30', 'regex:/^[ァ-ヶー]+$/u'],
            'under_name_kana' => ['required', 'string', 'max:30', 'regex:/^[ァ-ヶー]+$/u'],
            'mail_address' => ['required', 'string', 'email', 'max:100', 'unique:users,mail_address'],
            'sex' => ['required', 'in:1,2,3'],
            'old_year' => ['required', 'date_format:Y'],
            'old_month' => ['required','min:1', 'max:12'],
            'old_day' => ['required', 'min:1', 'max:31'],
            'role' => ['required', 'in:1,2,3,4'],
            'password' => ['required', 'string', 'min:8', 'max:30', 'confirmed'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {

            if (!checkdate($this->input('old_month'), $this->input('old_day'), $this->input('old_year'))) {
                $validator->errors()->add('old_day', '正しい日付を入力してください');
            }

                $year = $this->input('old_year');
                $month = $this->input('old_month');
                $day = $this->input('old_day');
                $birthday = Carbon::create($year, $month, $day);
                $today = Carbon::today();
                $minDate = Carbon::create(2000, 1, 1);

            if ($birthday->lessThan($minDate) || $birthday->greaterThan($today)) {
                $validator->errors()->add('old_year', '2000年1月1日から今日までの日付を選択してください。');
            }
        });
    }
}
