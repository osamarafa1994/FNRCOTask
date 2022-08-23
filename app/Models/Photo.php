<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'imageable_type','imageable_id', 'image'
    ];

       /**
     * Get the parent imageable model (post).
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
