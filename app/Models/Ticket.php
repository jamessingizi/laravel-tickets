<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string subject
 * @property string content
 * @property string name
 * @property string email
 * @property bool status
 * @method static first()
 * @method static where(string $string, false $false)
 * @method static count()
 * @method static select(string $string, $raw)
 */
class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'content',
        'name',
        'email',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
