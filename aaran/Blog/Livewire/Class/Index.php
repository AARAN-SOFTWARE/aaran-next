<?php

namespace Aaran\Blog\Livewire\Class;

use Aaran\Blog\Models\BlogCategory;
use Aaran\Blog\Models\BlogPost;
use Aaran\Blog\Models\BlogTag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use CommonTraitNew;

    use WithFileUploads;

    #region[properties]
    public string $body;
    public $users;
    public $image;
    public $old_image;
    public $BlogCategories;
    public $category_id;
    public $tags;
    public $tagfilter = [];
    public $visibility = false;
    #endregion


    public function mount()
    {
        $this->BlogCategories = BlogCategory::get();
    }
    #region[Get-Save]
    public function getSave(): void
    {
        if ($this->common->vname != '') {
            if ($this->common->vid == '') {
                $Post = new BlogPost();
                $extraFields = [
                    'body' => $this->body,
                    'blog_category_id' => $this->blog_category_id,
                    'blog_tag_id' => $this->blog_tag_id,
                    'image' => $this->saveImage(),
                    'user_id' => auth()->id(),
                    'visibility' => $this->visibility,

                ];
                $this->common->save($Post, $extraFields);
                $message = "Saved";
            } else {
                $Post = BlogPost::find($this->common->vid);
                $extraFields = [
                    'body' => $this->body,
                    'blog_category_id' => $this->blog_category_id,
                    'blog_tag_id' => $this->blog_tag_id,
                    'image' => $this->saveImage(),
                    'user_id' => auth()->id(),
                    'visibility' => $this->visibility,
                ];
                $this->common->edit($Post, $extraFields);
                $message = "Updated";
            }
            $this->dispatch('notify', ...['type' => 'success', 'content' => $message . ' Successfully']);
        }
    }
    #endregion

    #region[Get-Obj]
    public function getObj($id)
    {
        if ($id) {
            $Post = BlogPost::find($id);
            $this->common->vid = $Post->id;
            $this->common->vname = $Post->vname;
            $this->body = $Post->body;
            $this->blog_category_id = $Post->blogcategory_id;
            $this->blog_category_name = $Post->blogcategory_id?BlogCategory::find($Post->blogcategory_id)->vname:'';
            $this->blog_tag_id = $Post->blogtag_id;
            $this->blog_tag_name = $Post->blogtag_id?BlogTag::find($Post->blogtag_id)->vname:'';
            $this->common->active_id = $Post->active_id;
            $this->old_image = $Post->image;
            $this->visibility = $Post->visibility;
            return $Post;
        }
        return null;
    }
    #endregion

    #region[Clear-Fields]
    public function clearFields(): void
    {
        $this->common->vid = '';
        $this->common->vname = '';
        $this->common->active_id = '1';
        $this->body = '';
        $this->blog_category_id = '';
        $this->blog_category_name = '';
        $this->blog_tag_id = '';
        $this->blog_tag_name = '';
        $this->old_image = '';
        $this->image = '';
        $this->visibility = false;
    }
    #endregion

    #region[Image]
    public function saveImage()
    {
        if ($this->image) {

            $image = $this->image;
            $filename = $this->image->getClientOriginalName();

            if (Storage::disk('public')->exists(Storage::path('public/images/' . $this->old_image))) {
                Storage::disk('public')->delete(Storage::path('public/images/' . $this->old_image));
            }

            $image->storeAs('public/images', $filename);

            return $filename;

        } else {
            if ($this->old_image) {
                return $this->old_image;
            } else {
                return 'no image';
            }
        }
    }
    #endregion

    #region[blogCategory]
    public $blog_category_id = '';
    public $blog_category_name = '';
    public Collection $blogcategoryCollection;
    public $highlightBlogCategory = 0;
    public $blogcategoryTyped = false;

    public function decrementBlogcategory(): void
    {
        if ($this->highlightBlogCategory === 0) {
            $this->highlightBlogCategory = count($this->blogcategoryCollection) - 1;
            return;
        }
        $this->highlightBlogcategory--;
    }

    public function incrementBlogcategory(): void
    {
        if ($this->highlightBlogCategory === count($this->blogcategoryCollection) - 1) {
            $this->highlightBlogCategory = 0;
            return;
        }
        $this->highlightBlogCategory++;
    }

    public function setBlogcategory($name, $id): void
    {
        $this->blog_category_name = $name;
        $this->blog_category_id = $id;
        $this->getBlogcategoryList();
    }

    public function enterBlogcategory(): void
    {
        $obj = $this->blogcategoryCollection[$this->highlightBlogCategory] ?? null;

        $this->blog_category_name = '';
        $this->blogcategoryCollection = Collection::empty();
        $this->highlightBlogCategory = 0;

        $this->blog_category_name = $obj['vname'] ?? '';
        $this->blog_category_id = $obj['id'] ?? '';
    }

    public function refreshBlogcategory($v): void
    {
        $this->blog_category_id = $v['id'];
        $this->blog_category_name = $v['name'];
        $this->blogcategoryTyped = false;
    }

    public function blogcategorySave($name)
    {
        $obj = BlogCategory::create([
            'vname' => $name,
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
        $this->refreshBlogcategory($v);
    }

    public function getBlogcategoryList(): void
    {
        $this->blogcategoryCollection = $this->blog_category_name ?
            BlogCategory::search(trim($this->blog_category_name))->get() :
            BlogCategory::all();
    }

    #endregion

    #region[blogTag]
    public $blog_tag_id = '';
    public $blog_tag_name = '';
    public Collection $blogtagCollection;
    public $highlightBlogtag = 0;
    public $blogtagTyped = false;

    public function decrementBlogtag(): void
    {
        if ($this->highlightBlogtag === 0) {
            $this->highlightBlogtag = count($this->blogtagCollection) - 1;
            return;
        }
        $this->highlightBlogtag--;
    }

    public function incrementBlogtag(): void
    {
        if ($this->highlightBlogtag === count($this->blogtagCollection) - 1) {
            $this->highlightBlogtag = 0;
            return;
        }
        $this->highlightBlogtag++;
    }

    public function setBlogTag($name, $id): void
    {
        $this->blog_tag_name = $name;
        $this->blog_tag_id = $id;
        $this->getBlogtagList();
    }

    public function enterBlogtag(): void
    {
        $obj = $this->blogtagCollection[$this->highlightBlogtag] ?? null;

        $this->blog_tag_name = '';
        $this->blogtagCollection = Collection::empty();
        $this->highlightBlogtag = 0;

        $this->blog_tag_name = $obj['vname'] ?? '';
        $this->blog_tag_id = $obj['id'] ?? '';
    }

    public function refreshBlogtag($v): void
    {
        $this->blog_tag_id = $v['id'];
        $this->blog_tag_name = $v['name'];
        $this->blogtagTyped = false;
    }

    public function blogtagSave($name)
    {
        $obj = BlogTag::create([
            'blog_category_id' => $this->blog_category_id,
            'vname' => $name,
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
        $this->refreshBlogTag($v);
    }

    public function getBlogTagList(): void
    {
        $this->blogtagCollection = $this->blog_tag_name ?
            BlogTag::search(trim($this->blog_tag_name))->get() :
            BlogTag::all();
    }

    #endregion

    public function getCategory_id($id)
    {
        $this->category_id = $id;
        $this->gettags();
    }

    public function gettags()
    {
        $this->tags = BlogTag::where('blog_category_id', '=', $this->category_id)->get();
    }

    public function getFilter($id)
    {
        if (!in_array($id,$this->tagfilter,true)) {
            return array_push($this->tagfilter, $id);
        }
    }

    public function clearFilter()
    {
        $this->tagfilter=[];
    }

    public function removeFilter($id)
    {
        unset($this->tagfilter[$id]);
    }

    #region[Render]
    public function getRoute()
    {
        return route('posts');
    }
    public function render()
    {
        $this->getBlogcategoryList();
        $this->getBlogtagList();

        return view('blog::blog.index')->with([
            'list' => $this ->getListForm ->getList(BlogPost::class,function ($query){
                return $query->latest()->when($this->tagfilter,function ($query,$tagfilter){
                    return $query->whereIn('blog_tag_id',$tagfilter);
                });
            }),
            'firstPost'=>BlogPost::latest()->take(1)->when($this->tagfilter,function ($query,$tagfilter){
                return $query->whereIn('blog_tag_id',$tagfilter);
            })->get(),
        ]);
    }
    #endregion
}
