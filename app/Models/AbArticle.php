<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Route;

class AbArticle extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ab_article';
    protected $fillable =[
        'id',
        'ab_name',
        'ab_description',
        'ab_price',
        'ab_creator_id',
        'ab_createdate',
        'update_at'
    ];
    public function searchByName($searchTerm) {
        return $this->select('*')->where('ab_name', 'ILIKE', '%' . $searchTerm . '%')->get();
    }
    public function getImagePath($id) {
        $jpgImagePath = "/articelimages/{$id}.jpg";
        $pngImagePath = "/articelimages/{$id}.png";

        if (file_exists(public_path($jpgImagePath))) {
            return $jpgImagePath;
        } elseif (file_exists(public_path($pngImagePath))) {
            return $pngImagePath;
        }

        return '/articelimages/default.png'; // Pfad zu einem Standardbild
    }

}
