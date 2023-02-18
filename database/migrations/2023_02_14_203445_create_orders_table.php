<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('referred_by')->nullable();
            $table->string('channel');
            $table->string('reference');
            $table->decimal('biaya_adm', 14, 5);
            $table->decimal('sub_total', 14, 5);
            $table->decimal('total', 14, 5);
            $table->string('status')->default('pending');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate(DB::raw('NO ACTION'))
                ->onDelete(DB::raw('NO ACTION'));

            $table->foreign('referred_by')
                ->references('id')
                ->on('users')
                ->onUpdate(DB::raw('NO ACTION'))
                ->onDelete(DB::raw('NO ACTION'));

            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->onUpdate(DB::raw('NO ACTION'))
                ->onDelete(DB::raw('NO ACTION'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
