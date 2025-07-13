<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
        {
            Schema::create('items', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->integer('price');
                $table->text('brand')->nullable();
                $table->text('description');
                $table->string('img_url')->nullable();
                $table->string('image_path')->nullable(); // <- afterは不要
                $table->unsignedBigInteger('condition_id')->nullable();
                $table->timestamps();

                $table->foreign('condition_id')
                    ->references('id')
                    ->on('conditions')
                    ->onDelete('set null');
            });
        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
