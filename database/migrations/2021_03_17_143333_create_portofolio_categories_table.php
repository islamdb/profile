<?php

use App\Support\SEO;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortofolioCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portofolio_categories', function (Blueprint $table) {
            $table->id();
            $table->text('image');
            $table->string('name');
            $table->string('slug')
                ->unique();
            $table->text('description')
                ->nullable();
            SEO::metaColumns($table);
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
        Schema::dropIfExists('portofolio_categories');
    }
}