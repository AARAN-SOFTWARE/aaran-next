<?php

namespace Aaran\Website\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Aaran\Website\Models\BlogCategory;
use Aaran\Website\Models\BlogPost;
use Aaran\Website\Models\BlogTag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
class Blog extends Component
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
    public bool $active_id = true;
    #endregion

//    public function mount()
//    {
//        $this->blogCategories = BlogCategory::on($this->getTenantConnection())->get();
//    }


    public function rules(): array
    {
        return [
            'vname' => 'required|min:3|max:75',
            'body' => 'required|min:10|',
        ];
    }

    public function messages()
    {
        return [
            'vname.required' => ' :attribute is required.',
            'body.required' => ' :attribute is required.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'vname' => 'User name',
            'body' => 'Description',
        ];
    }

    #region[Get-Save]
    public function getSave(): void
    {
        $this->validate();
        $connection = $this->getTenantConnection();

        BlogPost::on($connection)->updateOrCreate(
            ['id' => $this->vid],
            [
                'vname' => Str::ucfirst($this->vname),
                'body' => $this->body,
                'blog_category_id' => $this->blog_category_id,
                'blog_tag_id' => $this->blog_tag_id,
                'image' => $this->saveImage(),
//                'user_id' => auth()->id(),
                'visibility' => $this->visibility,
                'active_id' => $this->active_id
            ],
        );
        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->clearFields();
    }
    #endregion

    #region[Get-Obj]
    public function getObj(int $id): void
    {
        if ($id) {
            $Post = BlogPost::on($this->getTenantConnection())->find($id);
            $this->vid = $Post->id;
            $this->vname = $Post->vname;
            $this->body = $Post->body;
            $this->blog_category_id = $Post->blog_category_id;
            $this->blog_category_name = $Post->blog_category_id?BlogCategory::on($this->getTenantConnection())->find($Post->blog_category_id)->vname:'';
            $this->blog_tag_id = $Post->blog_tag_id;
            $this->blog_tag_name = $Post->blog_tag_id?BlogTag::on($this->getTenantConnection())->find($Post->blog_tag_id)->vname:'';
            $this->active_id = $Post->active_id;
            $this->old_image = $Post->image;
            $this->visibility = $Post->visibility;
        }
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
        if ($this->highlightBlogcategory === 0) {
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

        $this->blog_category_name = $obj->vname ?? '';
        $this->blog_category_id = $obj->id ?? '';
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
            ->when($this->blog_category_name, fn($query) => $query->where('vname', 'like', "%{$this->blog_category_name}%"))
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

    #[On('refresh-blog_tag')]
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
        if (!in_array($id, $this->tagfilter, true)) {
            return array_push($this->tagfilter, $id);
        }
    }

    public function clearFilter()
    {
        $this->tagfilter = [];
    }

    public function removeFilter($id)
    {
        unset($this->tagfilter[$id]);
    }


    #region[Render]
    public function getRoute()
    {
        return route('blog');
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

    #region[Delete]
    public function deleteFunction(): void
    {
        if (!$this->deleteId) return;

        $obj = BlogPost::on($this->getTenantConnection())->find($this->deleteId);
        if ($obj) {
            $obj->delete();
        }
    }
    #endregion

    #region[render]
    #[Layout('Ui::components.layouts.web')]
    public function render()
    {
        $this->getBlogcategoryList();
        $this->getBlogtagList();

        return view('website::blog')->with([
            'list' => $this->getList(),
            'topPost' => BlogPost::on($this->getTenantConnection())->orderBy('created_at', 'desc')->first()
        ]);

//        $this->getListForm->perPage = 6;
//        return view('website::blog')->layout('layouts.web')->with([
//            'list' => $this->getListForm->getList(BlogPost::class, function ($query) {
//                return $query->latest()->whereIN('visibility', session()->get('tenant_id') ? [0, 1] : [1])
//                    ->when($this->tagfilter, function ($query, $tagfilter) {
//                        return $query->whereIn('blog_tag_id', $tagfilter);
//                    });
//            }),
//            'topPost' => BlogPost::take(4)->whereIN('visibility', session()->get('tenant_id') ? [0, 1] : [1])->when($this->tagfilter, function ($query, $tagfilter) {
//                return $query->whereIn('blog_tag_id', $tagfilter);
//            })->get(),
//        ]);
    }
    #endregion



}
