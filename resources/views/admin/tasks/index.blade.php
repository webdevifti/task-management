@extends('layouts.master')
@section('title', 'All Tasks')
@section('main_content')
    <main id="main" class="main">

        <div class="pagetitle">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1>All Tasks</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Tasks</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.manage-tasks.create') }}" class="btn btn-outline-primary btn-sm">Add New</a>
            </div>

        </div>

        <section class="section dashboard">
            <div class="row">
                <form action="{{ route('admin.manage-tasks.index') }}" method="GET" id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by Title or Number" value="{{ request()->search }}">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">All Statuses</option>
                                <option value="Pending" {{ request()->status == 'Pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="In Progress" {{ request()->status == 'In Progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="Completed" {{ request()->status == 'Completed' ? 'selected' : '' }}>Completed
                                </option>
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="due_date" class="form-control" value="{{ request()->due_date }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                            <a href="{{ route('admin.manage-tasks.index') }}" class="btn btn-danger w-100">Clear</a>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table">
                        @if ($tasks->count() > 0)
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Assigned to</th>
                                    <th>Completed At</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tasksTableBody">
                                @foreach ($tasks as $item)
                                    <tr id="row{{ $item->id }}">
                                        <td><a
                                                href="{{ route('admin.manage-tasks.show', $item->id) }}">#{{ $item->task_number }}</a>
                                        </td>
                                        <td>{{ $item->user?->name }}</td>
                                        <td>
                                            @if ($item->completed_at)
                                                @php
                                                    $completionTime = $item->created_at->diff($item->completed_at);
                                                @endphp
                                                <small>Time taken to complete: {{ $completionTime->d }} days,
                                                    {{ $completionTime->h }} hours, {{ $completionTime->i }} minutes</small>
                                            @else
                                                <small> not completed yet</small>
                                            @endif
                                        </td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>

                                            <span
                                                class="badge {{ $item->status == 'Completed' ? 'bg-success' : ($item->status == 'In Progress' ? 'bg-warning' : 'bg-danger') }}"
                                                id="statusShow{{ $item->id }}">
                                                {{ $item->status }}
                                            </span>

                                        </td>
                                        <td>{{ date('m/d/Y', strtotime($item->due_date)) }}</td>
                                        <td>{{ date('m/d/Y, H:i:s a', strtotime($item->created_at)) }}</td>
                                        <td>
                                            <button data-content='{{ json_encode($item) }}' data-bs-toggle="modal"
                                                data-bs-target="#statusConfirmation"
                                                class="btn btn-primary btn-sm statusBtn"><i
                                                    class="bi bi-pencil-fill"></i></button>
                                            <a href="{{ route('admin.manage-tasks.edit', $item->id) }}"
                                                class="btn btn-outline-success btn-sm"><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <a href="{{ route('admin.manage-tasks.show', $item->id) }}"
                                                class="btn btn-outline-primary btn-sm"><i class="bi bi-eye-fill"></i></a>

                                            <button data-bs-toggle="modal" data-bs-target="#delete"
                                                data-content='{{ json_encode($item) }}'
                                                class="btn btn-sm btn-outline-danger deleteBtn"><i
                                                    class="bi bi-trash-fill"></i></button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        @else
                            <div class="card">
                                <div class="card-body p-2">
                                    <h3 class="card-title text-center ">No Tasks Found</h3>
                                </div>
                            </div>
                        @endif
                    </table>
                    <div id="paginationLinks">
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- Delete Modal --}}
    <div class="modal" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="modalcontent">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>

                    <button type="submit" class="btn btn-danger" id="confirmDelete">Yes</button>

                </div>
            </div>
        </div>
    </div>

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
                </div>
                <div class="modal-footer text-end">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger" id="confirmUpdate">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('click', '.deleteBtn', function() {
            let parsedItem = $(this).data('content');

            $('#delete').find('.modal-body').html(`
            <p>Are you sure you want to delete task #${parsedItem.task_number}"?</p>
        `);
            $('#delete').data('task-id', parsedItem.id);
        });
        $('#delete').on('click', '#confirmDelete', function() {
            const taskId = $('#delete').data('task-id');

            $.ajax({
                url: `/admin/manage-tasks/${taskId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        iziToast.success({
                            position: 'topRight',
                            message: "Status has been deleted"
                        });
                        $(`#row${taskId}`).remove();

                    }
                    $('#delete').modal('hide');
                },
                error: function(xhr) {
                    iziToast.error({
                        position: 'topRight',
                        message: "Something happened wrong"
                    });
                }
            });
        });

        $(document).on('click', '.statusBtn', function() {
            let parsedItem = $(this).data('content');
            $('#statusConfirmation').find('.modal-body').html(`
                    <p>Update status for task #${parsedItem.task_number} titled "${parsedItem.title}".</p>
                    <select id="newStatus" class="form-control">
                        <option value="Pending" ${parsedItem.status === 'Pending' ? 'selected' : ''}>Pending</option>
                        <option value="In Progress" ${parsedItem.status === 'In Progress' ? 'selected' : ''}>In Progress</option>
                        <option value="Completed" ${parsedItem.status === 'Completed' ? 'selected' : ''}>Completed</option>
                    </select>
                `);
            $('#statusConfirmation').data('task-id', parsedItem.id);
        });

        $('#statusConfirmation').on('click', '#confirmUpdate', function() {
            const taskId = $('#statusConfirmation').data('task-id');

            const newStatus = $('#newStatus').val();
            var statusShow = $('#statusShow' + taskId);
            $.ajax({
                url: `/admin/manage-task/status/update/${taskId}`,
                method: 'POST',
                data: {
                    status: newStatus,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        iziToast.success({
                            position: 'topRight',
                            message: "Status has been updated"
                        });
                        statusShow.text(newStatus);
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
                    loadTasksTable();
                    $('#statusConfirmation').modal('hide');
                },
                error: function(xhr) {
                    iziToast.error({
                        position: 'topRight',
                        message: "Something happened wrong"
                    });
                }
            });
        });

        function loadTasksTable(page = 1) {
            $.ajax({
                url: "{{ route('admin.manage-tasks.live') }}",
                method: 'GET',
                data: {
                    page: page
                },
                success: function(res) {
                    let tasks = res.tasks.data;
                    let taskRows = '';

                    if (tasks.length > 0) {
                        tasks.forEach(item => {
                            taskRows += `
                            <tr id="row${item.id}">
                                <td><a href="/admin/manage-tasks/${item.id}">#${item.task_number}</a></td>
                                <td>${item.user?.name}</td>
                              <td>
            ${
                item.completed_at 
                ? (() => {
                    const createdAt = new Date(item.created_at);
                    const completedAt = new Date(item.completed_at);
                    const timeDiff = Math.abs(completedAt - createdAt);
                    
                    const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((timeDiff / (1000 * 60 * 60)) % 24);
                    const minutes = Math.floor((timeDiff / (1000 * 60)) % 60);

                    return `<small>Time taken to complete: ${days} days, ${hours} hours, ${minutes} minutes</small>`;
                })()
                : '<small>Not completed yet</small>'
            }
        </td>
                                <td>${item.title}</td>
                                <td>${item.description}</td>
                                <td>
                                    <span class="badge ${item.status == 'Completed' ? 'bg-success' : (item.status == 'In Progress' ? 'bg-warning' : 'bg-danger')}" id="statusShow${item.id}">
                                        ${item.status}
                                    </span>
                                </td>
                                <td>${new Date(item.due_date).toLocaleDateString()}</td>
                                <td>${new Date(item.created_at).toLocaleString()}</td>
                                <td>
                                    <button data-task-id='${item.id}' data-content='${JSON.stringify(item)}' data-bs-toggle="modal"
                                        data-bs-target="#statusConfirmation"
                                        class="btn btn-primary btn-sm statusBtn"><i class="bi bi-pencil-fill"></i></button>
                                    <a href="/admin/manage-tasks/${item.id}/edit"
                                        class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-square"></i></a>
                                    <a href="/admin/manage-tasks/${item.id}"
                                        class="btn btn-outline-primary btn-sm"><i class="bi bi-eye-fill"></i></a>
                                    <button data-task-id='${item.id}' data-bs-toggle="modal" data-bs-target="#delete"
                                        data-content='${JSON.stringify(item)}'
                                        class="btn btn-sm btn-outline-danger deleteBtn"><i class="bi bi-trash-fill"></i></button>
                                </td>
                            </tr>`;
                        });

                        $('#tasksTableBody').html(taskRows);
                        $('#paginationLinks').html(res.pagination);
                    } else {
                        $('#tasksTableBody').html(
                            '<tr><td colspan="7" class="text-center">No Tasks Found</td></tr>');
                    }

                },
                error: function(error) {
                    iziToast.error({
                        position: 'topRight',
                        message: "Error loading task"
                    });
                }
            });
        }

        let taskTableRefreshInterval;

        function startTaskTableRefresh() {
            taskTableRefreshInterval = setInterval(function() {
                let currentPage = $('#paginationLinks .active span').text();
                loadTasksTable(currentPage);
            }, 5000);;
        }
        $(document).on('click', '#paginationLinks a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            loadTasksTable(page);
        });

        function stopTaskTableRefresh() {
            clearInterval(taskTableRefreshInterval);
        }

        function hasQueryParameters() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.has('search') || urlParams.has('status') || urlParams.has('due_date');
        }

        $(document).ready(function() {
            if (!hasQueryParameters()) {
                startTaskTableRefresh();
            }
            $('#filterForm').on('submit', function() {
                stopTaskTableRefresh();
            });
        });
    </script>
@endsection
