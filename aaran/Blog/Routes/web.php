<?php

use Illuminate\Support\Facades\Route;
use Aaran\Blog\Livewire\Class;

//Blog
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/posts', Class\Index::class)->name('posts');
//    Route::get('/posts/{id}/show', \Aaran\Blog\Livewire\Class\Show::class)->name('posts.show');
//
//    Route::get('blogTags', \Aaran\Blog\Livewire\Class\Tag::class)->name('blogTags');
//    Route::get('blogCategory', \Aaran\Blog\Livewire\Class\Category::class)->name('blogCategory');

});
