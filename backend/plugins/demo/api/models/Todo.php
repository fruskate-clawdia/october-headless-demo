<?php namespace Demo\Api\Models;

use Model;

class Todo extends Model
{
    use \October\Rain\Database\Traits\Sortable;

    public $table = 'demo_api_todos';

    protected $fillable = ['title', 'done', 'sort_order'];

    protected $casts = ['done' => 'boolean'];

    public $rules = [
        'title' => 'required',
    ];

    public function toApiArray(): array
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'done'       => $this->done,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
