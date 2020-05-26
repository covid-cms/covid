<?php

namespace Covid\Base\Format;

use Covid\Framework\Model\Format;
use Covid\Base\Models\File;
use Illuminate\Database\Eloquent\Model;

class FileFormat extends Format
{
    const LITE = 'lite';
    const STANDARD = 'standard';

    public static function format($type, Model $file, array $options = [])
    {
        if ($type == static::LITE) {
            return static::formatLite($file);
        }

        if ($type == static::STANDARD) {
            return static::formatStd($file);
        }
    }

    protected static function formatLite(File $file)
    {
        return [
            'url' => url('storage/' . $file->path),
        ];
    }

    protected static function formatStd(File $file)
    {
        return [
            'url' => url('storage/' . $file->path),
        ];
    }
}
