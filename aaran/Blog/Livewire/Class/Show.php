<?php

namespace Aaran\Blog\Livewire\Class;

use Aaran\Assets\Trait\CommonTraitNew;
use Aaran\Blog\Models\BlogComment;
use Aaran\Blog\Models\BlogPost;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    use CommonTraitNew;


    public $posts;
    public $blog_post_id;
    public $vid = '';
    public $body;
    public $user_id;
    public $commentsCount;


    public function mount($id = null)
    {
        if ($id != null) {
            $this->posts = BlogPost::find($id);
            $this->blog_post_id = $id;
            $this->user_id = Auth::id();
            $this->commentsCount = BlogComment::where('blog_post_id', $id)->count();
        }
    }

    #region[Save]
    public function save()
    {
        $this->validate([
                'user_id' => 'required',
                'body' => 'required|min:3',
            ]
        );
        if ($this->blog_post_id != '') {
            if ($this->vid == '') {
                BlogComment::create([
                    'body' => $this->body,
                    'user_id' => Auth::id(),
                    'blog_post_id' => $this->blog_post_id,
                ]);
            } else {
                $comment = BlogComment::find($this->vid);
                $comment->body = $this->body;
                $comment->user_id = Auth::id();
                $comment->blog_post_id = $this->blog_post_id;
                if ($comment->user_id == Auth::id()) {
                    $comment->save();
                }
            }
            $this->clearFields();
        }
    }

    #endregion

    public
    function clearFields()
    {
        $this->body = '';

    }

    #region[Edit]
    public
    function editComment($id)
    {
        $obj = BlogComment::find($id);
        $this->vid = $obj->id;
        $this->body = $obj->body;
        $this->user_id = $obj->user_id;
        $this->blog_post_id = $obj->blog_post_id;
    }

    public
    function deleteComment($id)
    {
        $obj = BlogComment::find($id);
        $obj->delete();
    }

    #endregion

    public function getObj($id)
    {
        if ($id){
            $Comment = BlogComment::find($id);
            $this->common->vid = $Comment->id;
            return $Comment;
        }
        return null;
    }
    public
    function render()
    {
        return view('blog::blog.show')->with([
            'list' => BlogComment::where('blog_post_id', '=', $this->blog_post_id)->orderBy('created_at', 'desc')
                ->paginate(5)
        ]);
    }
}
