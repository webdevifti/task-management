@extends('layouts.master')
@section('title', 'Users')
@section('main_content')
    <main id="main" class="main">

        <div class="pagetitle">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1>Manage users</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.manage-users.create') }}" class="btn btn-outline-primary btn-sm">Add New</a>
            </div>

        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Assigned</th>
                            <th>Completed</th>
                            <th>Pending</th>
                            <th>In Progressed</th>
                            <th>Joined At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach ($users as $item)
                        <tr id="row{{$item->id}}">
                            <td>{{$item->id}}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->tasks->count() }}</td>
                            <td>{{ $item->tasks->where('status','Completed')->count() }}</td>
                            <td>{{ $item->tasks->where('status','Pending')->count() }}</td>
                            <td>{{ $item->tasks->where('status','In Progress')->count() }}</td>
                            <td>{{ date('d M Y', strtotime($item->created_at)) }}</td>
                            <td>
                                <a href="{{route('admin.manage-users.edit',$item->id)}}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-square"></i></a>
                                <a href="{{route('admin.manage-users.show',$item->id)}}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye-fill"></i></a>

                                <button data-bs-toggle="modal" data-bs-target="#delete"
                                    data-content='{{ json_encode($item) }}' data-user_id='{{$item->id}}'
                                    class="btn btn-sm btn-outline-danger deleteBtn"><i class="bi bi-trash-fill"></i></button>

                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$users->links()}}
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
@endsection

@section('scripts')
    <script>
      $(document).on('click', '.deleteBtn', function() {
            let parsedItem = $(this).data('content');

            $('#delete').find('.modal-body').html(`
            <p>Are you sure you want to delete user #${parsedItem.name}"?</p>
        `);
            $('#delete').data('user_id', parsedItem.id);
        });
        $('#delete').on('click', '#confirmDelete', function() {
            const user_id = $('#delete').data('user_id');
            $.ajax({
                url: `/admin/manage-users/${user_id}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        iziToast.success({
                            position: 'topRight',
                            message: "User has been deleted"
                        });
                        $(`#row${user_id}`).remove();

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
    </script>
@endsection
