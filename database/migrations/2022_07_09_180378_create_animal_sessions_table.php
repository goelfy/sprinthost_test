<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Создание таблицы модели App\Models\AnimalSession
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_sessions', function (Blueprint $table) {
            $table->id();
            $table->text('user_agent');
            $table->string('ip', 15);
            $table->timestamps();
        });
    }

    /**
     * Удаление таблицы модели App\Models\AnimalSession
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animal_sessions');
    }
};
