<?php namespace Demo\Api\Models;

use Model;

/**
 * Post Model — standard OctoberCMS/Eloquent model
 */
class Post extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;

    public $table = 'demo_api_posts';

    protected $slugs = ['slug' => 'title'];

    protected $fillable = ['title', 'slug', 'content', 'published'];

    public $rules = [
        'title' => 'required|min:3',
        'slug'  => 'unique:demo_api_posts',
    ];

    // Scope: only published posts for public API
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    // API representation
    public function toApiArray(): array
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'slug'      => $this->slug,
            'content'   => $this->content,
            'published' => $this->published,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
