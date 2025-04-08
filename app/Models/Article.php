<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // La table associée au modèle
    protected $table = 't_article';

    // La clé primaire de la table
    protected $primaryKey = 'id_art';

    // Les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'ident_art', 'date_art', 'readtime_art', 'title_art', 'hook_art',
        'url_art', 'fk_category_art', 'content_art', 'image_art'
    ];

    // Les colonnes de type date
    protected $dates = ['date_art'];

    // Indique que cette table n'a pas de colonne `created_at` ni `updated_at`
    public $timestamps = false;

    // Définir la relation avec la catégorie
    public function category()
    {
        return $this->belongsTo(Category::class, 'fk_category_art', 'id_cat');
    }
}
