<?php

namespace App\Models;

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



    public function user()
    {
        return $this->belongsTo(User::class);
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
