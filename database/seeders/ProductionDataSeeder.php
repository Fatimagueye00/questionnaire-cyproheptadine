<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductionDataSeeder extends Seeder
{
    public function run(): void
    {
        $questions = json_decode(
            file_get_contents(base_path('questions.json')),
            true
        );

        $answers = json_decode(
            file_get_contents(base_path('answers.json')),
            true
        );

        foreach ($questions as $question) {
            DB::table('questions')->updateOrInsert(
                ['id' => $question['id']],
                $question
            );
        }

        foreach ($answers as $answer) {
            DB::table('answers')->updateOrInsert(
                ['id' => $answer['id']],
                $answer
            );
        }

        $this->command->info('20 questions et leurs réponses ont été importées.');
    }
}