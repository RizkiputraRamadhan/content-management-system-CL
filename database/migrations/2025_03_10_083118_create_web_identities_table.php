<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('web_identities', function (Blueprint $table) {
            $table->id();
            $table->string('web_name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('domain')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->string('google_maps')->nullable();
            $table->string('favicon')->nullable();
            $table->string('logo')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('version')->nullable();
            $table->timestamps();
        });
    }

    # Menghapus tabel web_identities jika migrasi dibatalkan
    public function down()
    {
        Schema::dropIfExists('web_identities');
    }
};
