<?php

namespace Tests\Unit\Services;

use App\Services\StorageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorageServiceTest extends TestCase
{
    /**
     * @access public
     * @return void
     */
    public function test_putFile_ファイルを保存すること(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('test.jpg');
        $file_name = StorageService::putFile(StorageService::ICON_DIRECTORY, $file);

        // ファイルを保存すること
        Storage::assertExists('images/icon/' . $file_name);
    }

    /**
     * @access public
     * @return void
     */
    public function test_delete_ファイルを削除すること(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('test.jpg');
        $file_name = StorageService::putFile(StorageService::ICON_DIRECTORY, $file);
        Storage::assertExists('images/icon/' . $file_name);
        StorageService::delete(StorageService::ICON_DIRECTORY, $file_name);

        // ファイルを削除すること
        Storage::assertMissing('images/icon/' . $file_name);
    }
}
