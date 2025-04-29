<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->integer('ci')->nullable();
            $table->string('email')->unique();
            $table->string('celular')->nullable();
            $table->string('genero')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable()->default('img/default-avatar.jpg');
            $table->tinyInteger('status')->default(1)->unsigned();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
