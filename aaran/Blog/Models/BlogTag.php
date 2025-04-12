<?php

namespace Aaran\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    protected $guarded = [];

//    public static function blogTag($id)
//    {
//        $blogTag = BlogTag::find($id);
//        return $blogTag ? $blogTag->vname : null; // Return null if not found
//    }

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id'); // Ensure correct foreign key name
    }

    public static function search(string $searches)
    {
        return empty($searches) ? static::query()
            : static::where('vname', 'like', '%' . $searches . '%');
    }

}
