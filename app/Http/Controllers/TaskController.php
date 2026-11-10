<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function today(): View
    {
        return view('welcome', ['tasks' => Task::today()->orderedByDate()->get()]);
    }

    public function index(): View
    {
        return view('tasks', ['tasks' => Task::orderedByDate()->get()]);
    }
}
