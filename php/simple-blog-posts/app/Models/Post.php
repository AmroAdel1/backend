<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model        // eloquent
{
    use HasFactory;

    protected $fillable = [             // protect from mass assignment      // using second method of inserting data
        'title',
        'description',
        'user_id',
    ];

    // one to many
    public function user() {      // eloquent relationships     // naming convention        // user_id in posts table
        return $this->belongsTo(User::class);    // this => this Model obj.
    }

    public function posted_by() {           // nullable      // we don't have posted_by id in posts table
        // return $this->belongsTo(User::class);
        return $this->belongsTo(User::class, 'user_id');        // get model object of user by user_id
    }
}
// Eloquent
// ORM(Object Relational Mapping) => from migrations to models and vice versa  // database objects to objects
// ORM => Eloquent implements active record pattern

// symfony(framework) => doctrine implements data mapper pattern
