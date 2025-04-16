<?php

namespace Aaran\Blog\Livewire\Class;
;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\Blog\Models\BlogCategory;
use Aaran\Blog\Models\BlogTag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Tag extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    #region[properties]
    public string $vname = '';
    public $active_id = true;
    #endregion

    #region[Validation]
    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.blog_tags,vname"),
            'blog_category_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'vname.required' => ':attribute is missing.',
            'vname.unique' => 'This :attribute is already created.',
            'blog_category_id.required' => ':attribute is required.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'vname' => 'Tag name',
            'blog_category_id' => 'Blog Category',
        ];
    }
    #endregion[Validation]

    #region[Get-Save]
    public function getSave()
    {
        $this->validate();
        $connection = $this->getTenantConnection();

        BlogTag::on($connection)->updateOrCreate(
            ['id' => $this->vid],
            [
                'vname' => $this->vname,
                'blog_category_id' => $this->blog_category_id,
                'active_id' => $this->active_id,
            ]);
        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->clearFields();
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
        $this->highlightBlogCategory--;
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
            'active_id' => 1
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

    public function getObj($id)
    {
        if ($id) {
            $BlogTag = BlogTag::on($this->getTenantConnection())->find($id);
            $this->vid = $BlogTag->id;
            $this->vname = $BlogTag->vname;
            $this->active_id = $BlogTag->active_id;
            $this->blog_category_id = $BlogTag->blog_category_id;
            $this->blog_category_name = optional($BlogTag->blogCategory)->vname ?? '-';

            return $BlogTag;
        }
        return null;
    }

    public function clearFields()
    {
        $this->vid = null;
        $this->vname = '';
        $this->active_id = '1';
        $this->blog_category_id = '';
        $this->blog_category_name = '';
    }

    #region[getList]
    public function getList()
    {
        return BlogTag::on($this->getTenantConnection())
            ->active($this->activeRecord)
            ->when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }
    #endregion

    #region[delete]
    public function deleteFunction(): void
    {
        if (!$this->deleteId) return;

        $obj = BlogTag::on($this->getTenantConnection())->find($this->deleteId);
        if ($obj) {
            $obj->delete();
        }
    }
    #endregion

    #region[Render]
    public function render()
    {
        $this->getBlogcategoryList();

        return view('blog::tag')->with([
            'list' => $this->getList(),
            BlogTag::on($this->getTenantConnection())
            ->when( function ($query) {
                return $query->where('id', '>', '');
            })
        ]);
    }
    #endregion
}
