<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Format\FileFormat;
use App\Models\Formattable;

class File extends Model implements Formattable
{
    protected $table = 'files';

    protected $primaryKey = 'id';

    public function format($type)
    {
        return FileFormat::format($type, $this);
    }
}
