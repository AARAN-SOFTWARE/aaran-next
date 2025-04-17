<?php

namespace Aaran\Blog\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\Blog\Models\BlogComment;
use Aaran\Blog\Models\BlogPost;
use Livewire\Component;

class Show extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    #region[Properties]
    public $posts;
    public $blog_post_id;
    public $body;
    public $user_id;
    public $commentsCount;
    #endregion

    public function mount($id = null)
    {
        if ($id != null) {
            $this->posts = BlogPost::on($this->getTenantConnection())->find($id);
            $this->blog_post_id = $id;
//            $this->user_id = Auth::id();
            $this->commentsCount = BlogComment::on($this->getTenantConnection())->where('blog_post_id', $id)->count();
        }
    }

    #region[Save]
    public function getSave()
    {
        $this->validate();
        $connection = $this->getTenantConnection();

        BlogComment::on($connection)->updateOrCreate(
            ['id' => $this->vid],
            [
                'body' => $this->body,
//                'user_id' => Auth::id(),
                'blog_post_id' => $this->blog_post_id,
            ],
        );

        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->clearFields();

    }
    #endregion

    public
    function clearFields()
    {
        $this->vid = null;
        $this->blog_post_id = '';
//        $this->user_id = '';
        $this->body = '';
    }

    #region[Edit]
    public function editComment(int $id): void
    {
        $obj = BlogComment::on($this->getTenantConnection())->find($id);
        $this->vid = $obj->id;
        $this->body = $obj->body;
//        $this->user_id = $obj->user_id;
        $this->blog_post_id = $obj->blog_post_id;
    }

    #region[Delete]
    public function deleteFunction(): void
    {
        if (!$this->deleteId) return;

        $obj = BlogComment::on($this->getTenantConnection())->find($this->deleteId);
        if ($obj) {
            $obj->delete();
        }
    }
    #endregion

    public function getObj(int $id): void
    {
        if ($obj = BlogComment::on($this->getTenantConnection())->find($id)) {
            $this->vid = $obj->id;
            $this->body = $obj->body;
//        $this->user_id = $obj->user_id;
            $this->blog_post_id = $obj->blog_post_id;
        }
    }

    public function getList()
    {
        return BlogComment::on($this->getTenantConnection())
            ->active($this->activeRecord)
            ->when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }
    public function render()
    {
        return view('blog::show', ['list' => $this->getList()])->with([
            'list' => BlogComment::on($this->getTenantConnection())->where('blog_post_id', '=', $this->blog_post_id)->orderBy('created_at', 'desc')
                ->paginate(5)
        ]);
    }
}
