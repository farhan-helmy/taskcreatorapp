@extends('master')

@section('content')
<div class="d-flex flex-column-fluid">
    <div class="container">
        @if ($errors->any())
        <div class="card card-custom">
            <ul>
                @foreach ($errors->all() as $error)
                <div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">{{ $error }}</div>
                    <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                        </button>
                    </div>
                </div>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom" id="kt_todo_list">
                    <!--begin::Header-->
                    <div class="card-header align-items-center flex-wrap border-0 ">
                        <!--begin::Toolbar-->
                        <div class="card-title">
                            <h3 class="card-label">Workspaces {{$workspace->workspace_name}}
                                <span class="d-block text-muted pt-2 font-size-sm"></span>
                            </h3>
                        </div>
                        <div class="d-flex flex-wrap align-items-center">
                            <div class="d-flex align-items-center mr-1 my-2">

                            </div>
                            <div class="d-flex align-items-center mr-1 my-2">
                            </div>
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center my-2">

                            <a href="{{route('workspace.task.create', ['workspace' => $workspace->id])}}" class="btn btn-light-success btn-sm text-uppercase font-weight-bolder">New Task</a>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body p-0">
                        <!--begin::Responsive container-->
                        {!! $task->table() !!}
                        <!--end::Responsive container-->
                    </div>
                    <!--end::Body-->
                </div>
            </div>
        </div>

    </div>
</div>
@endsection


@push('scripts')
{!! $task->scripts() !!}
@endpush