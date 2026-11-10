@if($tasks->isEmpty())
    <p>{{ $emptyMessage }}</p>
@else
    <div class="table-scroll" role="region" aria-label="Task list" tabindex="0">
        <table>
            <thead>
                <tr><th scope="col">Task</th><th scope="col">Status</th><th scope="col">Date</th></tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td class="status">{{ $task->status }}</td>
                        <td class="task-date">{{ $task->task_date->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
