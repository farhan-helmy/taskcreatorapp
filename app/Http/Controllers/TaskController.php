<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Workspace;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Html\Builder;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Workspace $workspace)
    {
        $task = $builder->columns([
            ['data' => 'task_name', 'name' => 'name', 'title' => 'Task'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            ['data' => 'due_date', 'name' => 'due_date', 'title' => 'Due'],
            [
                'defaultContent' => '',
                'data'           => 'action',
                'name'           => 'action',
                'title'          => 'Action',
                'render'         => null,
                'orderable'      => false,
                'searchable'     => false,
                'exportable'     => false,
                'printable'      => true,
                'footer'         => '',
            ]
        ])
            ->parameters(['responsive' => true])
            ->ajax(route('workspace.task.data', ['workspace' => $workspace->id]));

        return view('workspace.show', compact('task', 'workspace'));
    }

    public function data(Workspace $workspace)
    {

        $tasks = Task::where('workspace_id', $workspace->id)->get();

        return DataTables::of($tasks)
            ->editColumn('action', function ($tasks) use ($workspace) {
                $task =  '<a href="tasks/' . $tasks->id . '/show" class="btn btn-success"> Show</a>';
                return $task;
            })
            ->editColumn('status', function ($tasks) {
                if ($tasks->status) {
                    $task = '<span class="label label-light-success font-weight-bold label-inline">Complete</span>';
                    return $task;
                } else {
                    $task = '<span class="label label-light-danger font-weight-bold label-inline">Incomplete</span>';
                    return $task;
                }
            })
            ->editColumn('due_date', function ($tasks) {

                if ($tasks->status) {
                    $task = '<p></p>';
                    return $task;
                } else {
                    $task = Carbon::parse($tasks->due_date)->diffForHumans();
                    return $task;
                }
            })
            ->rawColumns(['action', 'status', 'due_date'])
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Workspace $workspace)
    {
        return view('task.create', compact('workspace'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Workspace $workspace)
    {
        $data = $request->validate([
            'task_name' => 'required|string',
            'due_date' => 'required|date|after_or_equal:today'
        ]);

        //dd($data);

        $task = Task::create(
            collect($data)
                ->only(['task_name', 'due_date'])
                ->toArray()
        );

        $workspace->tasks()->save($task);

        return redirect()
            ->route('workspace.task.index', ['workspace' => $workspace->id])
            ->with('success', 'Task added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Workspace $workspace, Task $task)
    {
        $created = Carbon::parse($task->created_at)->diffForHumans();
        $due = Carbon::parse($task->due_date)->diffForHumans();
        $completed = Carbon::parse($task->updated_at)->diffForHumans();
        return view('task.show', compact('task', 'created', 'due', 'workspace', 'completed'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Workspace $workspace, Task $task)
    {
        $task->status = true;
        $task->save();

        return redirect()
            ->route('workspace.task.index', ['workspace' => $workspace->id])
            ->with('success', 'Task completed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
