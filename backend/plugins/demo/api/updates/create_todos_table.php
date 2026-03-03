<?php namespace Demo\Api\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTodosTable extends Migration
{
    public function up(): void
    {
        Schema::create('demo_api_todos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('done')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demo_api_todos');
    }
}
