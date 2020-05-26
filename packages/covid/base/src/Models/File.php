<?php

namespace Covid\Base\Models;

use Illuminate\Database\Eloquent\Model;
use Covid\Base\Format\FileFormat;
use Covid\Framework\Model\Formattable;

class File extends Model implements Formattable
{
    protected $table = 'files';

    protected $primaryKey = 'id';

    public function format($type)
    {
        return FileFormat::format($type, $this);
    }
}
