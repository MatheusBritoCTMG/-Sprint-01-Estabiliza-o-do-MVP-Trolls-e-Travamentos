<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * TICKET #006 (Moderação / Status Público):
 * Adiciona a coluna booleana "is_public" na tabela "perguntas".
 * Por padrão vem como false: toda pergunta enviada fica pendente de
 * moderação até o organizador aprová-la e liberá-la para o telão.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perguntas', function (Blueprint $table) {
            $table->boolean('is_public')->default(false)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('perguntas', function (Blueprint $table) {
            $table->dropColumn('is_public');
        });
    }
};
