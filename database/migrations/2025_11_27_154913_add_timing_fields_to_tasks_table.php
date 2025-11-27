<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->date('start_date')->nullable()->after('status');
        $table->date('end_date')->nullable()->after('start_date');
        $table->decimal('estimated_hours', 5, 2)->nullable()->after('end_date');
        $table->decimal('actual_hours', 5, 2)->nullable()->after('estimated_hours');
    });
}

public function down(): void
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->dropColumn(['start_date', 'end_date', 'estimated_hours', 'actual_hours']);
    });
}

};
