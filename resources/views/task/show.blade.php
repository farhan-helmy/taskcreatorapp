@extends('master')

@section('content')
<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="card card-custom gutter-b">
            <!--begin::Body-->
            <div class="card-body">
                <!--begin::Section-->
                <div class="d-flex align-items-center">
                    <!--begin::Info-->
                    <div class="d-flex flex-column mr-auto">
                        <!--begin: Title-->
                        <a href="#" class="card-title text-hover-primary font-weight-bolder font-size-h5 text-dark mb-1">{{$task->task_name}}</a>

                    </div>
                    <!--end::Info-->
                    <div class="card-toolbar">
                    <a href="{{route('workspace.task.index', ['workspace'=> $workspace->id])}}" class="btn btn-primary btn-sm text-uppercase font-weight-bolder mt-5 mt-sm-0 mr-auto mr-sm-0 ml-sm-auto">Go back</a>
                    </div>
                </div>
                <!--end::Section-->
                <!--begin::Content-->
                <div class="d-flex flex-wrap mt-14">
                    <div class="mr-12 d-flex flex-column mb-7">
                        <span class="d-block font-weight-bold mb-4">Created</span>
                        <span class="btn btn-light-primary btn-sm font-weight-bold btn-upper btn-text">{{$created}}</span>
                    </div>
                    <div class="mr-12 d-flex flex-column mb-7">

                    @if($task->status)                    
                        <span class="d-block font-weight-bold mb-4">Completed</span>
                        <span class="btn btn-light-success btn-sm font-weight-bold btn-upper btn-text">{{$completed}}</span>
                        @else
                        <span class="d-block font-weight-bold mb-4">Due</span>
                        <span class="btn btn-light-danger btn-sm font-weight-bold btn-upper btn-text">{{$due}}</span>
                        @endif
                    </div>
                    <!--begin::Progress-->
                    <div class="flex-row-fluid mb-7">
                        <span class="d-block font-weight-bold mb-4">Progress</span>
                        <div class="d-flex align-items-center pt-2">
                            @if($task->status)
                            <span class="label label-light-success font-weight-bold label-inline">Completed</span>
                            @else
                            <span class="label label-light-danger font-weight-bold label-inline">Incomplete</span>
                            @endif
                        </div>
                    </div>
                    <!--end::Progress-->
                </div>
                <!--end::Content-->

            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            @if($task->status)

            @else

            <div class="card-footer d-flex align-items-center">
                <div class="d-flex">

                </div>
                <form action="{{route('workspace.task.update', ['workspace' => $workspace->id, 'task'=> $task->id])}}" method="POST">
                    @csrf

                    <button type="submit" class="btn btn-success btn-sm text-uppercase font-weight-bolder mt-5 mt-sm-0 mr-auto mr-sm-0 ml-sm-auto">complete</button>
                </form>
               
            </div>
            @endif
            <!--end::Footer-->
        </div>

    </div>
</div>

@endsection