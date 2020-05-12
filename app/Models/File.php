<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Format\FileFormat;

class File extends Model
{
    protected $table = 'files';

    protected $primaryKey = 'id';

    public function format($type)
    {
        return FileFormat::format($type, $this);
    }
}
