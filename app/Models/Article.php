<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'ab_articlecategory';

    protected $fillable = [
        'ab_name', 'ab_description', 'ab_parent',
    ];

    // Deaktiviere die Zeitstempel-Funktionalität
    public $timestamps = false;

    // Hier könnten weitere benutzerdefinierte Methoden oder Beziehungen definiert werden
}
