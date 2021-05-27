<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [ 'bot_code', 'expected_entries', 'bot_response', 'translation_language', 'next_step' ];
}
