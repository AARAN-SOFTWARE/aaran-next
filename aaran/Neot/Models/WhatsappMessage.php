<?php

namespace Aaran\Neot\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappMessage extends Model
{
    protected $fillable = ['sender', 'receiver', 'message'];
}
