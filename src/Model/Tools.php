<?php


namespace App\Model;


use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Tools
{
    private const MIMES = [
        'pdf' => 'application/pdf',
        'zip' => 'application/zip',
        'gzip' => 'application/gzip',
        'mp3' => 'audio/mp3',
        'mp4' => 'audio/mp4',
        'mpeg' => 'audio/mpeg',
        'wma' => 'audio/x-ms-wma',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/pjpeg',
        'gif' => 'image/gif',
        'png' => 'image/png',
        'tiff' => 'image/tiff',
        'txt' => 'text/plain',
        'mp4v' => 'video/mp4',
        'mpegv' => 'video/mpeg',
        'wmv' => 'video/x-ms-wmv',
        'fly' => 'video/x-fly',
        '3gpp' => 'video/3gpp',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    /**
     * @param $mime_type
     * @return bool
     */
    public static function isImage($mime_type)
    {
        return strpos($mime_type, 'image') === 0;
    }

    /**
     * @param $mime_type
     * @return bool
     */
    public static function isDoc($mime_type)
    {
        return strpos($mime_type, 'application') === 0
            || strpos($mime_type, 'text') === 0;
    }

    /**
     * @param int $length
     * @return string
     */
    public static function generateDigitCode(int $length = 6)
    {
        $randStr = '';
        $feed = "123456789";
        for ($i = 0; $i < $length; $i++) {
            $randStr .= substr($feed, rand(0, strlen($feed) - 1), 1);
        }

        return $randStr;
    }

    public static function getExt($mime, $name = null)
    {
        $res = array_search($mime, self::MIMES);
        if ($res) {
            return $res;
        }
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        if (in_array($ext, array_keys(self::MIMES))) {
            return $ext;
        }
        return false;
    }

    /**
     * @param UploadedFile $file
     * @throws Exception
     */
    public static function verifyImageFile(UploadedFile $file)
    {
        if ($file->getError() != 0) {
            throw new Exception($file->getErrorMessage());
        }
        if (!self::isImage($file->getMimeType())) {
            throw new Exception('Файл не является картинкой');
        }
    }

    /**
     * @param UploadedFile $file
     * @throws Exception
     */
    public static function verifyDocFile(UploadedFile $file)
    {
        if ($file->getError() != 0) {
            throw new Exception($file->getErrorMessage());
        }
        if (!self::isDoc($file->getMimeType())) {
            throw new Exception('Файл не является документом');
        }
    }

}