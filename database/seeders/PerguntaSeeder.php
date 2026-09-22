<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\Pergunta;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PerguntaSeeder extends Seeder
{
    public function run(): void
    {
        // Garante que existam alguns usuários (participantes) para vincular às perguntas
        // (Ticket #003 - Relacionamento N:1 entre Pergunta e User)
        $usuarios = User::query()->count() > 0
            ? User::all()
            : User::factory()->count(10)->create();

        $userIds = $usuarios->pluck('id')->all();

        // Injeta 5.000 perguntas de teste no evento principal para simular a carga pesada
        $perguntas = [];
        $agora = Carbon::now();

        for ($i = 1; $i <= 5000; $i++) {
            $perguntas[] = [
                'evento_id'  => 1,
                // Cerca de 20% das perguntas ficam sem autor para testar o fallback 'Anônimo'
                'user_id'    => $i % 5 === 0 ? null : $userIds[array_rand($userIds)],
                'texto'      => "Pergunta de teste #{$i}: Como a arquitetura lida com alta demanda de acessos simultâneos?",
                'status'     => 'pendente',
                // Cerca de 60% já aprovadas/públicas pelo organizador, o restante pendente de moderação
                'is_public'  => $i % 5 !== 0,
                'created_at' => $agora->copy()->subSeconds(5000 - $i),
                'updated_at' => $agora->copy()->subSeconds(5000 - $i),
            ];

            if ($i % 500 === 0) {
                Pergunta::insert($perguntas);
                $perguntas = [];
            }
        }

        // Injeta 5 perguntas no evento secundário
        for ($j = 1; $j <= 5; $j++) {
            Pergunta::create([
                'evento_id'  => 2,
                'user_id'    => $userIds[array_rand($userIds)],
                'texto'      => "Pergunta do workshop #{$j}: O que é o Service Container?",
                'status'     => 'aprovado',
                'is_public'  => true,
            ]);
        }
    }
}
