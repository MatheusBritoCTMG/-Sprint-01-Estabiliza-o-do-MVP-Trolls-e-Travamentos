<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * TICKET #003 (Relacionamento N:1):
 * Adiciona a coluna de chave estrangeira "user_id" na tabela "perguntas"
 * para vincular cada pergunta ao usuário (participante) que a fez.
 *
 * A coluna é nullable() para manter compatibilidade com perguntas antigas
 * (sem autor) e para permitir o fallback seguro de "Anônimo" na view.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perguntas', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('evento_id')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('perguntas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
