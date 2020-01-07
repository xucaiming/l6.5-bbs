<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    public function root()
    {

//        $validator = \Validator::make([
//            'name' => '1255',
//            'age' => 22,
//        ], [
//            'name' => 'required|between:3,10',
//            'age' => 'lt:10'
//        ]);
//
//        if($validator->fails()){
////            return redirect()->route('root')->withErrors($validator); // 重定向显示错误信息
////            dd($validator->errors()->toArray());  // 获取所有错误信息
//        }

//        echo 1111; exit;

        return view('pages.root');
    }

    public function permissionDenied()
    {
        // 如果当前用户有权限访问后台，直接跳转访问
        if (config('administrator.permission')()) {
            return redirect(url(config('administrator.uri')), 302);
        }
        // 否则使用视图
        return view('pages.permission_denied');
    }
}
