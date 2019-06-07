<?php

namespace Modules\Page\Entities;

use Greabock\Tentacles\EloquentTentacle;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use UsesTenantConnection, EloquentTentacle,SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table='page__pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'body'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'author_type', 'author_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'null'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'slug' => 'string',
        'body' => 'string',
        'author_type' => 'string',
        'author_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Returns the User who is the author of this Post
     *
     * @return MorphTo
     */
    public function author(): MorphTo
    {
        return $this->morphTo();
    }
}
