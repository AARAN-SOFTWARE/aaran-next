<?php

namespace Aaran\Website\Models;
use Illuminate\Database\Eloquent\Model;
class BlogCategory extends Model
{
    protected $guarded = [];


    public static function blogTag($id)
    {
        return BlogCategory::find($id)->vname;
    }


    public static function search(string $searches)
    {
        return empty($searches) ? static::query()
            : static::where('vname', 'like', '%' . $searches . '%');
    }
}
