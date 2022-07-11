<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Создание таблицы модели App\Models\AnimalKind
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_kinds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('max_size');
            $table->integer('max_age');
            $table->decimal('growth_factor');
            $table->string('img');
            $table->timestamps();
        });
    }

    /**
     * Удаление таблицы модели App\Models\AnimalKind
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animal_kinds');
    }
};
