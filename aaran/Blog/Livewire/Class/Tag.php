<?php

namespace Aaran\Blog\Livewire\Class;
;
use Aaran\Blog\Models\BlogCategory;
use Aaran\Blog\Models\BlogTag;
use Illuminate\Support\Collection;
use Livewire\Component;

class Tag extends Component
{
    use CommonTraitNew;

    #region[Get-Save]

    public function getSave()
    {
        if ($this->common->vname != '') {
            if ($this->common->vid == '') {
                $blogTag = new BlogTag();
                $extraFields = [
                    'blog_category_id' => $this->blog_category_id,
                ];
                $this->common->save($blogTag, $extraFields);
                $message = "Saved";
            } else {
                $blogTag = BlogTag::find($this->common->vid);
                $extraFields = [
                    'blog_category_id' => $this->blog_category_id,
                ];
                $this->common->edit($blogTag, $extraFields);
                $message = "Updated";
            }
        }
        $this->dispatch('notify', ...['type' => 'success', 'content' => $message . ' Successfully']);
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
        $obj = BlogCategory::create([
            'vname' => $name,
            'active_id' => 1
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

    public function getObj($id)
    {
        if ($id) {
            $BlogTag = BlogTag::find($id);
            $this->common->vid = $BlogTag->id;
            $this->common->vname = $BlogTag->vname;
            $this->common->active_id = $BlogTag->active_id;
            $this->blog_category_id = $BlogTag->blog_category_id;
            $this->blog_category_name = optional($BlogTag->blogCategory)->vname ?? '-';

            return $BlogTag;
        }
        return null;
    }

    #region[delete]
    public function deleteFunction($id): void
    {
        if ($id) {
            $obj = BlogTag::find($id);
            if ($obj) {
                $obj->delete();
                $message = "Deleted Successfully";
                $this->dispatch('notify', ...['type' => 'success', 'content' => $message]);
            }
        }
    }
    #endregion

    public function clearFields()
    {
        $this->common->vid = '';
        $this->common->vname = '';
        $this->common->active_id = '1';
        $this->blog_category_id = '';
        $this->blog_category_name = '';
    }

    #region[Render]
    public function render()
    {
        $this->getBlogcategoryList();

        return view('blog::blog.tag')->with([
            'list' => $this->getListForm->getList(BlogTag::class, function ($query) {
                return $query->where('id', '>', '');
            })
        ]);
    }
    #endregion
}
