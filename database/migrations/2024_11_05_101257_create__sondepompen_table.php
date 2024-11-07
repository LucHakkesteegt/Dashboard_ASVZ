<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSondepompenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sondepomp', function (Blueprint $table) {
            $table->id();
            $table->string('name');             // Naam van de sondepomp
            $table->string('model')->nullable(); // Model van de sondepomp (optioneel)
            $table->string('serial_number')->unique(); // Uniek serienummer
            $table->text('description')->nullable(); // Beschrijving van de sondepomp
            $table->date('installation_date')->nullable(); // Installatiedatum
            $table->timestamps();               // Bevat created_at en updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sondepomp');
    }
}
