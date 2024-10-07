@extends('layouts.master')
@section('title', 'Task')
@section('main_content')
    <main id="main" class="main">

        <div class="pagetitle">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1>{{$task->title}}</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.manage-tasks.index') }}">Tasks</a></li>
                            <li class="breadcrumb-item active">{{$task->title}}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.manage-tasks.index') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-arrow-left"></i></a>
                    <button data-content='{{ json_encode($task) }}' data-bs-toggle="modal"
                        data-bs-target="#statusConfirmation" class="btn btn-primary btn-sm statusBtn"><i class="bi bi-pencil-fill"></i></button>
                </div>
            </div>

        </div>

        <section class="section dashboard">
            <div class="row">

                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <strong>#{{ $task->task_number }}</strong>
                                 <span
                                        class="badge {{ $task->status == 'Completed' ? 'bg-success' : ($task->status == 'In Progress' ? 'bg-warning' : 'bg-danger') }}"
                                        id="statusShow">
                                        {{ $task->status }}
                                    </span>
                            </div>
                            <p>Assigned to : <strong>{{$task->user?->name}}</strong></p>
                            <h3 class="card-title">{{ $task->title }}</h3>
                            <p>{{ $task->description }}</p>
                            @if ($task->image)
                            <hr>
                                <h3 class="card-title">Image File</h3>

                                <a href="{{ asset( $task->image) }}">
                                    <img width="100" height="100" src="{{ asset( $task->image) }}"
                                        class="img-fluid rounded" alt="">
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
    {{-- Status Confirm --}}
    <div class="modal" id="statusConfirmation" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="statusConfirmationLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Update Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formStatus">
                        @csrf
                        <div>
                            <label for="">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer text-end">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $('.statusBtn').click(function() {
            var modal = $('#statusConfirmation');
            var content = $(this).data('content');
            modal.find('#status').val(content.status);
            var form_action = "{{ route('admin.manage-task.update.status', ':contentId') }}";
            form_action = form_action.replace(':contentId', content.id);
            modal.find('#formStatus').attr('action', form_action);
            modal.modal('show');
            $('#formStatus').submit(function(e) {
                e.preventDefault();
                var status = $('#status').val();
                var statusShow = $('#statusShow');
                $.ajax({
                    url: form_action,
                    type: 'POST',
                    data: {
                        status: status,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            iziToast.success({
                                position: 'topRight',
                                message: "Status has been updated"
                            });
                            statusShow.text(status);
                            statusShow.removeClass(
                                'bg-success bg-warning bg-danger');
                            if (status === 'Completed') {
                                statusShow.addClass('bg-success');
                            } else if (status === 'In Progress') {
                                statusShow.addClass('bg-warning');
                            } else {
                                statusShow.addClass('bg-danger');
                            }

                        } else {
                            iziToast.error({
                                position: 'topRight',
                                message: "Failed to update"
                            });
                        }
                        modal.modal('hide');
                    },
                    error: function(xhr, status, error) {
                        iziToast.error({
                            position: 'topRight',
                            message: "Error updating status"
                        });
                    }
                });
            });
        });
    </script>
@endsection
