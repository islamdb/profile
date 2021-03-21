<?php

use App\Support\SEO;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')
                ->unique();
            $table->decimal('price', 24, 4)
                ->default(0);
            $table->decimal('discount', 24, 4)
                ->default(0);
            $table->longText('body')
                ->nullable();
            $table->boolean('active')
                ->default(true);
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
        Schema::dropIfExists('products');
    }
}
