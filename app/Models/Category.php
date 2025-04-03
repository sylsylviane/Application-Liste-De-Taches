<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Http\Resources\CategoryResource;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category'];

    public $timestamps = false;

    public function tasks(){
        return $this->hasMany(Task::class);
    }
    
    /**
     * Méthode pour définir l'attribut "category" comme un tableau JSON
     * et le convertir en chaîne JSON lors de la sauvegarde
     */
    protected function category(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>json_decode($value, true),
            set: fn($value) =>json_encode($value)
        );
    }

    /**
     * Méthode pour récupérer toutes les catégories. Convertit les enregistrements de la base de données en une représentation JSON à l'aide de CategoryResource.
     * 
     * @return array
     */
    static public function categories(){
        $resource = CategoryResource::collection(self::select()->orderby('category')->get() )->resolve();
        return $resource;
    }
}
