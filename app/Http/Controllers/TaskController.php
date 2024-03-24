<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {

        $yesterday_tasks = Task::where('date', '<', date('Y-m-d'))->orderBy('date', 'desc')->get();
        $today_tasks = Task::where('date', date('Y-m-d'))->orderBy('date', 'desc')->get();
        $tomorrow_tasks = Task::where('date', '>', date('Y-m-d'))->orderBy('date', 'desc')->limit(15)->get();

        return view('pages.tasks.index', compact('yesterday_tasks', 'today_tasks', 'tomorrow_tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'installment_id' => 'required',
            'customer_id' => 'required',
            'task' => 'required',
            'date' => 'required',
        ]);

        $task = Task::create([
            'installment_id' => $request->installment_id,
            'customer_id' => $request->customer_id,
            'user_id' => auth()->id(),
            'task' => $request->task,
            'date' => $request->date,
            'status' => false,
            'result' => null,
        ]);

        return redirect()->back()->with('success', 'Задача успешно создана');
    }
}
