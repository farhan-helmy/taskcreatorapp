<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Html\Builder;


class WorkspaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {

        $workspace = $builder->columns([
            ['data' => 'workspace_name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At'],
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
            ->ajax(route('workspace.data'));

        return view('workspace.index', compact('workspace'));
    }

    public function data()
    {

        $workspaces = Workspace::where('user_id', Auth::id())->get();

        return DataTables::of($workspaces)
            ->editColumn('action', function ($workspaces) {
                $workspace =  '<a href="workspace/' . $workspaces->id . '/tasks" class="btn btn-success"> View</a>';
                return $workspace;
            })
            ->rawColumns(['action'])
            ->make();
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('workspace.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'workspace_name' => 'required|string'
        ]);

        $workspace = Workspace::create(
            collect($data)
                ->only(['workspace_name'])
                ->toArray()
        );

        $user->workspaces()->save($workspace);

        return redirect()
            ->route('workspace.index')
            ->with('success', 'Workspace created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Workspace $workspace)
    {

        return view('workspace.show', compact('workspace'));
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
    public function update(Request $request, $id)
    {
        //
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
