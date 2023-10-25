<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class StorageService
{
    public const ICON_DIRECTORY = 'images/icon';
    public const PRODUCT_DIRECTORY = 'images/product';

    /**
     * ファイルを保存する
     * 
     * @access public
     * @param  UploadedFile $file
     * @return string 保存したファイル名
     */
    public static function putFile(string $directory, UploadedFile $file): string
    {
        $file_path = Storage::putFile($directory, $file);
        return basename($file_path);
    }
}
