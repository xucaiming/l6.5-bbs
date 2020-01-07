<?php

namespace App\Handlers;

use Illuminate\Support\Str;

class ImageUploadHandler
{
    protected $allow_ext = ['png', 'jpg', 'jpeg', 'gif'];

    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        $folder_name = 'uploads/images/' . $folder . '/' . date('Ym/d', time());
        $upload_path = public_path() . '/' . $folder_name;
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png'; //获取文件的后缀名

        if(! in_array($extension, $this->allow_ext)){
            return false;
        }
        $filename = $file_prefix . '_' . time() . '' . Str::random(10) . '.' . $extension;

        $file->move($upload_path, $filename);

        if($max_width && $extension != 'gif'){
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];
    }
    
    /**
     *裁剪图像
     */
    public function reduceSize($file_path, $max_width)
    {
        $image = \Image::make($file_path);

        $image->resize($max_width, null, function($constraint){

            // 设置指定宽度，高度自适应
            $constraint->aspectRatio();

            //防止裁图时图片尺寸变大
            $constraint->upsize();

        });

        $image->save(); // 将修改后的图片保存
    }
}