<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    //protected $table = "task";
    //protected $primaryKey = "taskId";
    //protected $timestamp = false;

    protected $fillable = [
        'title',
        'description',
        'completed',
        'due_date',
        'user_id',
        'category_id'
    ];

    /**
     * Méthode pour définir la relation entre la tâche et l'utilisateur 
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    /**
     * Méthode pour définir la relation entre la tâche et la catégorie
     */
    public function category(){
        return $this->belongsTo(Category::class);
    }

}
