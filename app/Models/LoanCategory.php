<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Contracts\Auditable;

class LoanCategory extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $primaryKey = 'id';
    protected $fillable = ['name', 'slug', 'icon', 'description', 'status', 'created_by'];
    protected $appends = ['icon_url'];
    public function getIconUrlAttribute()
    {

        $brandLogoPath = 'category/'.$this->icon;
        $url = Storage::url($brandLogoPath);
        $path = asset($url);

        return $this->icon ? $path : null;
    }
}
