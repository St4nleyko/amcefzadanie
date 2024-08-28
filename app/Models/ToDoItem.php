<?php

namespace App\Models;

use App\Http\Controllers\CategoryController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToDoItem extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'is_completed',
        'name',
        'description'
    ];



    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'item_users');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_items');
    }


    //showcase for dynamic models
    protected $inputsConfigs = [
        'name'=>[
            'type' => 'text',
            'value' => null
        ],
        'description'=>[
            'type' => 'textarea',
            'value' => null
        ],
        'is_sharable'=>[
            'type' => 'checkbox',
            'value' => null
        ],
        //...
    ];
    public function getInputsConfigs()
    {
        return $this->inputsConfigs;
    }
}
