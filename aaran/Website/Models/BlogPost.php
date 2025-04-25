<?php

namespace Aaran\Website\Models;
use Aaran\Core\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPost extends Model
{
    protected $guarded = [];

    public function scopeActive(Builder $query, $status = '1'): Builder
    {
        return $query->where('active_id', $status);
    }

    public function scopeSearchByName(Builder $query, string $search): Builder
    {
        return $query->where('vname', 'like', "%$search%");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
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

    public function scopeType($query, $categoryId)
    {
        return $query->where('blog_category_id', $categoryId);
    }

    public static function getCategoryName($categoryId)
    {
        return BlogCategory::find($categoryId)?->name;
    }

    public function tag()
    {
        return $this->belongsTo(BlogTag::class, 'blog_tag_id');
    }

}
