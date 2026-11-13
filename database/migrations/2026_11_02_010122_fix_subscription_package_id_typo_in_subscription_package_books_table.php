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
        if (Schema::hasColumn('subscription_package_books', 'subcription_package_id')) {
            Schema::table('subscription_package_books', function (Blueprint $table) {
                $table->dropForeign(['subcription_package_id']);
                $table->renameColumn('subcription_package_id', 'subscription_package_id');
                $table->foreign('subscription_package_id')->references('id')->on('subscription_packages')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('subscription_package_books', 'subscription_package_id')) {
            Schema::table('subscription_package_books', function (Blueprint $table) {
                $table->dropForeign(['subscription_package_id']);
                $table->renameColumn('subscription_package_id', 'subcription_package_id');
                $table->foreign('subcription_package_id')->references('id')->on('subscription_packages')->onDelete('cascade');
            });
        }
    }
};
