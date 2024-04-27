<?php

namespace App\Console\Commands;

use App\Mail\TaskReminderMail;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send';
    protected $description = 'Send reminder emails for upcoming tasks';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::whereDate('due_date', Carbon::tomorrow())->get();
        foreach ($tasks as $task) {
            Mail::to($task->user->email)->send(new TaskReminderMail($task));
        }

        $this->info('Reminder emails sent successfully.');
    }
}
