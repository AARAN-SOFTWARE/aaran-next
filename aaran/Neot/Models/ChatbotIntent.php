<?php

namespace Aaran\Neot\Models;

use Illuminate\Database\Eloquent\Model;
class ChatbotIntent extends Model
{
    protected $fillable = ['title', 'pattern', 'handler_class', 'priority'];
}
