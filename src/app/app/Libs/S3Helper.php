<?php

namespace App\Libs;

use Illuminate\Support\Facades\Storage;
use RuntimeException;

class S3Helper
{
    /**
     * 画像アップロード
     *
     * @param string $uploadPath
     * @param $file
     *
     * @return string
     * @throws RuntimeException
     */
    public function uploadFilePublic($uploadPath, $file)
    {
        $path = Storage::disk('s3')
            ->putFileAs(
                $uploadPath,
                $file,
                time() . '.' . $file->getClientOriginalExtension(),
            );

        return $path;
    }

    /**
     * SSE付き画像アップロード
     *
     * @param string $uploadPath
     * @param $file
     *
     * @return string
     * @throws RuntimeException
     */
    public function uploadFileSecurity($uploadPath, $file)
    {
        $path = Storage::disk('s3-security')
            ->putFileAs(
                $uploadPath,
                $file,
                time() . '.' . $file->getClientOriginalExtension(),
                'security'
            );

        return $path;
    }

    /**
     * This method is used to upload file
     *
     * @param FilePath   $filePath
     *
     * @return object
     * @throws RuntimeException
     */
    public function getFilePublic($filePath)
    {
        if (!$filePath) {
            return null;
        }
        return Storage::disk('s3')->url($filePath);
    }

    /**
     * This method is used to upload file
     *
     * @param string $filePath
     *
     * @return string
     * @throws RuntimeException
     */
    public function getFileSecurity($filePath)
    {
        if (!$filePath) {
            return null;
        }

        $s3 = Storage::disk('s3-security');
        $client = $s3->getDriver()
            ->getAdapter()
            ->getClient();
        $filename = basename($filePath); //ファイル名を抜き出し
        $new_filename = urlencode($filename); // ファイル名を指定
        $command = $client->getCommand('GetObject', [
            'Bucket'                        => config('filesystems.disks.s3-security.bucket'),
            'Key'                           => "$filePath" ,
            'ResponseContentDisposition'    => "application/json; filename=\"{$new_filename}\"" , // ファイル名を指定
        ]);
        $expiry = "+10 minutes";
        $request = $client->createPresignedRequest($command, $expiry);
        $url = (string) $request->getUri();

        return $url;
    }

    /**
     * 画像ファイル削除
     *
     * @param string $path
     *
     * @throws RuntimeException
     */
    public function deleteFilePublic($path): void
    {
        Storage::disk('s3')->delete($path);
    }
}
