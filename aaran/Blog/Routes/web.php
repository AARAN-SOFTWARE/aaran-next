<?php

use Illuminate\Support\Facades\Route;
use Aaran\Blog\Livewire\Class;

//Blog
Route::middleware('auth')->group(function () {

    Route::get('/posts', Class\Index::class)->name('posts');
    Route::get('blogCategory', Class\Category::class)->name('blogCategory');
    Route::get('/posts/{id}/show', Class\Show::class)->name('posts.show');
    Route::get('blogTags', Class\Tag::class)->name('blogTags');

});
