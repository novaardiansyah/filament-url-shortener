<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('urls', function (Blueprint $table) {
      $table->integer('click_count')->default(0)->after('shortener_url');
      $table->string('notes')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('urls', function (Blueprint $table) {
      $table->dropColumn('click_count');
      $table->dropColumn('notes');
    });
  }
};
