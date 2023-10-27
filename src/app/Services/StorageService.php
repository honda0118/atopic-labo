<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class StorageService
{
    /** @const icon directory */
    public const ICON_DIRECTORY = 'images/icon';
    /** @const product directory */
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

    /**
     * ファイルを削除する
     * 
     * @access public
     * @param  string $directory
     * @param  string $file_name
     * @return void
     */
    public static function delete(string $directory, string $file_name): void
    {
        Storage::delete($directory . '/' . $file_name);
    }
}
