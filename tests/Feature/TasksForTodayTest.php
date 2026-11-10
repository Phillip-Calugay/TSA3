<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TasksForTodayTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_meets_record_and_date_requirements_and_can_be_repeated(): void
    {
        $this->travelTo(Carbon::parse('2026-11-10 12:00:00', config('app.timezone')));
        $this->seed();
        $this->seed();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('tasks', 10);
        $this->assertGreaterThanOrEqual(3, Task::get()->pluck('task_date')->unique()->count());
        $this->assertSame(2, Task::today()->count());
        $original = Task::where('title', 'Technical 4 - Cross-Border Compliance (Case Study)')->sole();
        $this->assertSame('2026-10-02', $original->task_date->format('Y-m-d'));
    }

    public function test_welcome_filters_by_the_current_local_date(): void
    {
        // This UTC time is already November 11 in the application's Manila timezone.
        $this->travelTo(Carbon::parse('2026-11-10 16:30:00', 'UTC'));
        Task::create(['title' => 'Yesterday task', 'task_date' => '2026-11-10']);
        Task::create(['title' => 'Today task', 'task_date' => '2026-11-11']);
        Task::create(['title' => 'Tomorrow task', 'task_date' => '2026-11-12']);

        $this->get('/')->assertOk()
            ->assertSee('November 11, 2026')
            ->assertSee('Today task')
            ->assertDontSee('Yesterday task')
            ->assertDontSee('Tomorrow task');
    }

    public function test_task_list_includes_every_date_in_chronological_order(): void
    {
        Task::create(['title' => 'Last task', 'task_date' => '2026-11-12']);
        Task::create(['title' => 'First task', 'task_date' => '2026-11-09']);
        Task::create(['title' => 'Middle task', 'task_date' => '2026-11-10']);

        $this->get('/tasks')->assertOk()->assertSeeInOrder(['First task', 'Middle task', 'Last task']);
    }

    public function test_profile_and_about_display_the_expected_information(): void
    {
        $this->seed();
        $this->get('/profile')->assertOk()->assertSee('demo_student')
            ->assertSee('Demo Student')->assertSee('demo.student@example.com');
        $this->get('/about')->assertOk()->assertSee('Phillip Calugay')->assertSee('Laravel');
    }

    public function test_empty_states_work_without_seeded_records(): void
    {
        $this->get('/')->assertOk()->assertSee('No tasks are scheduled for today.');
        $this->get('/tasks')->assertOk()->assertSee('No tasks found.');
        $this->get('/profile')->assertOk()->assertSee('No user profile found.');
    }

    public function test_task_content_is_escaped_in_both_task_views(): void
    {
        Task::create(['title' => '<script>alert(1)</script>', 'task_date' => today()]);
        foreach (['/', '/tasks'] as $url) {
            $this->get($url)->assertOk()->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
                ->assertDontSee('<script>alert(1)</script>', false);
        }
    }

    public function test_database_supplies_pending_as_the_default_status(): void
    {
        $id = DB::table('tasks')->insertGetId(['title' => 'Default status task', 'task_date' => today()->toDateString()]);
        $this->assertSame('pending', Task::findOrFail($id)->status);
    }

    public function test_usernames_are_unique(): void
    {
        User::factory()->create(['username' => 'same_username']);
        $this->expectException(QueryException::class);
        User::factory()->create(['username' => 'same_username']);
    }
}
