<?php

use App\Models\AnimalKind;
use App\Models\AnimalSession;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Создание таблицы модели App\Models\Animal
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AnimalSession::class)->index();
            $table->foreignIdFor(AnimalKind::class);
            $table->integer('age');
            $table->timestamps();
        });
    }

    /**
     * Удаление таблицы модели App\Models\Animal
     *
     * @return void
     */
    public function down()
    {
        DB::table('animals')->truncate();
        Schema::dropIfExists('animals');
    }
};
