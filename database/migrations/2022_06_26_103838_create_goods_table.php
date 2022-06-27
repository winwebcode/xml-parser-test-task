<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('images');
            $table->string('serial_number');
            $table->integer('code'); //код товара
            $table->string('storage'); //склад
            $table->string('region');
            $table->string('original_price');
            $table->text('engineer_comment');
            $table->text('reason_discount_expand'); //причина уценки развернуто
            $table->string('condition');
            $table->string('serviceability')->nullable(); //работоспособность / испавность
            $table->date('guarantee_cancel_date')->nullable();
            $table->text('kit')->nullable(); //комплект
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
}
