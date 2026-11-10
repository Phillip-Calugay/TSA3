<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['username' => 'demo_student'], [
            'full_name' => 'Demo Student',
            'email' => 'demo.student@example.com',
            'created_at' => '2026-09-29 08:00:00',
        ]);

        $tasks = [
            ['[AI Prohibited] Summative Assessment 1 - 1TSY2627_IT0035_TC31-3', 'pending', '2026-09-30'],
            ['Quiz 2 - Module 1 - 1TSY2627_IT0035_TC31-3', 'pending', '2026-09-30'],
            ['[TECHNICAL] [AI-ASSISTED] Technical Formative Assessment 3: Module 3', 'pending', '2026-09-30'],
            ['[AI-INTEGRATED] Module 3: CodeIgniter Forms, Validation, File Upload, and CRUD', 'pending', '2026-10-01'],
            ['[F3-FORMATIVE] Module 3: CodeIgniter Forms, Validation, File Upload, and CRUD', 'pending', '2026-10-01'],
            ['[TECHNICAL] [AI-PROHIBITED] Technical Summative Assessment 1: Module 1 and Module 2', 'pending', '2026-10-01'],
            ['[AI-ASSISTED] Module 3: CodeIgniter Forms, Validation, File Upload, and CRUD', 'completed', '2026-10-02'],
            ['Technical 4 - Cross-Border Compliance (Case Study)', 'pending', '2026-10-02'],
            ['Review the Laravel Tasks for Today pages', 'pending', today()->toDateString()],
            ['Verify TSA3 migrations, seeder, and Eloquent queries', 'completed', today()->toDateString()],
        ];

        foreach ($tasks as [$title, $status, $date]) {
            Task::updateOrCreate(['title' => $title], [
                'status' => $status,
                'task_date' => $date,
            ]);
        }
    }
}
