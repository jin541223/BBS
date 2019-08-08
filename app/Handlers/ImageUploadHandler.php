<?php
namespace App\Handlers;

use Illuminate\Support\Str;

/**
 * 图片上传
 */
class ImageUploadHandler
{
    protected $allowed_ext = ['png', 'jpg', 'gif', 'jpeg'];

    public function save($file, $floder, $file_prefix)
    {
        // 存储文件目录
        $folder_name = 'uploads/images/'.$floder.'/' . date('YMd', time());

        // public_path 获取 public 文件夹的物理路径
        $upload_path = public_path() . '/'.$folder_name;

        // 文件后缀名
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        // 增加前缀为了增加辨析度
        $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }
        // 移动文件到目标存储路径中
        $file->move($upload_path, $filename);

        return ['path' => config('app.url') . '/' . $folder_name . '/' . $filename];
    }
}
