<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ab_user extends Model
{
    use HasFactory;
    protected $table = 'ab_user';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ab_name',
        'ab_mail',
        'ab_password'
    ];
    public $timestamps = false;

}
