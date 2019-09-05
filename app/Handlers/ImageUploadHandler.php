<?php
namespace App\Handlers;

use Image;

/**
 * 图片上传
 */
class ImageUploadHandler
{
    protected $allowed_ext = ['png', 'jpg', 'gif', 'jpeg'];

    public function save($file, $floder, $file_prefix, $max_width = false)
    {
        // 存储文件目录
        $folder_name = "uploads/images/$floder/" . date("YMd", time());

        // public_path 获取 public 文件夹的物理路径
        $upload_path = public_path() . '/' . $folder_name;

        // 文件后缀名
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        // 增加前缀为了增加辨析度
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }
        // 移动图片到目标存储路径
        $file->move($upload_path, $filename);

        if ($max_width && $extension != 'gif') {
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return ['path' => config('app.url') . '/' . $folder_name . '/' . $filename];
    }

    public function reduceSize($file_path, $max_width)
    {
        $image = Image::make($file_path);

        $image->resize($max_width, null, function ($constraint) {
            // 设定宽度为 $max_width, 高度等比例缩放
            $constraint->aspectRatio();

            // 防止图片裁剪时图片尺寸变大
            $constraint->upsize();
        });

        // 图片保存
        $image->save();
    }
}
