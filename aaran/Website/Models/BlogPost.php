<?php

namespace Aaran\Website\Models;
use Illuminate\Database\Eloquent\Model;
class BlogPost extends Model
{
    protected $guarded = [];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(BlogTag::class);
    }

    public static function type($id)
    {
        return BlogCategory::find($id)->vname ?? 'Unknown';
    }


    public static function tagName($str)
    {
        if ($str) {
            return BlogTag::find($str)->vname;
        } else return '';
    }
}
