<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $casts = [
        "start_at" => "date",
    ];

    public function user(): BelongsTo
    {

/*
 how to use in the view?
 $model->relatedtable()-> ...
 this comes before the database request

 $model->relatedtable->property
 this comes after the database request
 this gives you the model entity/property which you can use or see easily.
 */


        return $this->belongsTo(User::class);
    }
}
