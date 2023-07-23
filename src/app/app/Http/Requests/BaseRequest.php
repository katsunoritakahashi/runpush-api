<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BaseRequest extends FormRequest
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
            //
        ];
    }

    /**
     * [override]
     *
     * @param Validator $validator
     * @throw HttpResponseException
     * @see FormRequest::failedValidation()
     */
    protected function failedValidation( Validator $validator )
    {
        throw new ValidationException(
            null,
            null,
            $validator->errors()->toArray()
        );
    }

    public function validated($key = null, $default = null)
    {
        return toSnakeArrayRecursive($this->validator->validated());
    }
}

function toSnakeArrayRecursive(array $array)
{
    $results = [];
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $results[Str::snake($key)] = toSnakeArrayRecursive($value);
        } else {
            $results[Str::snake($key)] = $value;
        }
    }
    return $results;
}

/**
 * CSV形式リクエストパラメータを配列に変換するユーティリティ関数
 *
 * note: 通常配列指定するとうまく扱ってくれるのだが、
 *  multipart-form になるとうまく扱ってくれないケースがあるようなので、
 *  補助関数でフォローする。
 */
function convertFromCsvToArray($name, $param)
{
    $val = $param[$name];
    if (is_array($val)) {
        $ret = array();
        foreach ($val as $v) {
            $ret = array_merge($ret, explode(",", $v));
        }
        return [$name => $ret];
    } else {
        return [$name => explode(",", $val)];
    }
}

