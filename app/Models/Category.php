<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
        // La table associée au modèle
        protected $table = 't_category';
        protected $primaryKey = 'id_cat';
        // Les articles associés à cette catégorie
        public function articles()
        {
            return $this->hasMany(Article::class, 'fk_category_art');
        }
}
