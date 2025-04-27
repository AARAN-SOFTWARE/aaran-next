<?php

namespace Aaran\Blog\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\Blog\Models\BlogCategory;
use Aaran\Blog\Models\BlogPost;
use Aaran\Blog\Models\BlogTag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    use WithFileUploads;

    #region[properties]
    public string $vname = '';
    public string $body;
    public $users;
    public $image;
    public $old_image;
    public $BlogCategories;
    public $category_id;
    public $tags;
    public $tagfilter = [];
    public $visibility = false;
    public $active_id = true;
    #endregion

    public function mount()
    {
        $this->BlogCategories = BlogCategory::on($this->getTenantConnection())->get();
    }

    #region[Get-Save]
    public function getSave(): void
    {
        $connection = $this->getTenantConnection();

        BlogPost::on($connection)->updateOrCreate(
            ['id' => $this->vid],
        [
            'vname' => $this->vname,
            'body' => $this->body,
            'blog_category_id' => $this->blog_category_id,
            'blog_tag_id' => $this->blog_tag_id,
            'image' => $this->saveImage(),
            'visibility' => $this->visibility,
            'active_id' => $this->active_id,
        ]);
        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->clearFields();
        }
    #endregion

    #region[Get-Obj]
    public function getObj($id)
    {
        if ($id) {
            $obj = BlogPost::on($this->getTenantConnection())->find($id);
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->body = $obj->body;
            $this->blog_category_id = $obj->blogcategory_id;
            $this->blog_category_name = $obj->blogcategory_id?BlogCategory::on($this->getTenantConnection())->find($obj->blogcategory_id)->vname:'';
            $this->blog_tag_id = $obj->blogtag_id;
            $this->blog_tag_name = $obj->blogtag_id?BlogTag::on($this->getTenantConnection())->find($obj->blogtag_id)->vname:'';
            $this->active_id = $obj->active_id;
            $this->old_image = $obj->image;
            $this->visibility = $obj->visibility;
            return $obj;
        }
        return null;
    }
    #endregion

    #region[Clear-Fields]
    public function clearFields(): void
    {
        $this->vid = null;
        $this->vname = '';
        $this->active_id = true;
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
    public $blogcategoryCollection;
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
        $obj = BlogCategory::on($this->getTenantConnection())->create([
            'vname' => $name,
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
        $this->refreshBlogcategory($v);
    }

    public function getBlogcategoryList(): void
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->blogcategoryCollection = DB::connection($this->getTenantConnection())
            ->table('blog_categories')
            ->when($this->blog_category_name, fn($query) => $query->where('vname', 'like',  "%{$this->blog_category_name}%"))
            ->get();
    }

    #endregion

    #region[blogTag]
    public $blog_tag_id = '';
    public $blog_tag_name = '';
    public $blogtagCollection;
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
        $obj = BlogTag::on($this->getTenantConnection())->create([
            'blog_category_id' => $this->blog_category_id,
            'vname' => $name,
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
        $this->refreshBlogTag($v);
    }

    public function getBlogTagList(): void
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->blogtagCollection = DB::connection($this->getTenantConnection())
            ->table('blog_tags')
            ->when($this->blog_tag_name, fn($query) => $query->where('vname', 'like', "%{$this->blog_tag_name}%"))
            ->get();
    }

    #endregion

    public function getCategory_id($id)
    {
        $this->category_id = $id;
        $this->gettags();
    }

    public function gettags()
    {
        $this->tags = BlogTag::on($this->getTenantConnection())->where('blog_category_id', '=', $this->category_id)->get();
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

    #region[getList]
    public function getList()
    {
        return BlogPost::on($this->getTenantConnection())
            ->active($this->activeRecord)
            ->when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }
    #endregion
    public function render()
    {
        $this->getBlogcategoryList();
        $this->getBlogtagList();

        return view('blog::index', [
            'list' => $this->getList(),
            'firstPost' => BlogPost::on($this->getTenantConnection())
                ->latest()
                ->take(5)
                ->when($this->tagfilter, function ($query, $tagfilter) {
                    return $query->whereIn('blog_tag_id', $tagfilter);
                })
                ->get(),
        ]);
    }

    #endregion
}
