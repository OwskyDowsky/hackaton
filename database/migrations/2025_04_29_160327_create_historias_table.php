<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriasTable extends Migration
{
    public function up()
    {
        Schema::create('historias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Nombre visible de la historia
            $table->string('archivo_json'); // Archivo .json relacionado
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historias');
    }
}
