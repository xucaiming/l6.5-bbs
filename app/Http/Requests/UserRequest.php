<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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

    // 某个属性第一次验证失败后停止运行验证规则，需要加上bail
    public function rules()
    {
        return [
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . \Auth::id(),
            'email' => 'required|email',
            'introduction' => 'max:80',
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width:208,min_height=208',
        ];
    }

    public function messages()
    {
        return [
            'avatar.mimes' => '头像必须是jpeg, bmp, png, gif格式的图片',
            'avatar.dimensions' => '图片的清晰度不够，宽和高需要208px以上',
            'name.unique' => '用户名已被占用，请重新填写',
            'name.regex' => '用户名这只支持英文字母、数字、下划线、横杠',
            'name.between' => '用户名必须介于3-25个字符之间',
            'name.required' => '用户名不能为空',
        ];
    }
}
