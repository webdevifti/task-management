@extends('layouts.master')
@section('title', 'Create A New User')

@section('main_content')
    <main id="main" class="main">

        <div class="pagetitle">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1>Create A New User</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Create User</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.manage-users.index') }}" class="btn btn-outline-primary btn-sm"><i
                        class="bi bi-arrow-left"></i></a>
            </div>

        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="card p-2">
                    <div class="card-body">
                        <form id="userCreateForm">

                            <div class="mb-2">
                                <label for=""><strong>Name</strong></label>
                                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}"
                                    class="form-control" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for=""><strong>Email</strong></label>
                                <input type="email" name="email" placeholder="Email" class="form-control"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <span class="text-primary">By Default Password is 1234567890</span>
                            </div>
                            <div class="mb-2">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#userCreateForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/admin/manage-users",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#userCreateForm')[0].reset();
                            iziToast.success({
                                position: 'topRight',
                                message: "User has been created."
                            });
                        }
                    },
                    error: function(xhr) {

                        if (xhr.status === 422) {

                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                iziToast.error({
                                    position: 'topRight',
                                    message: value[0]
                                });
                            });
                        } else {
                            iziToast.error({
                                position: 'topRight',
                                message: "Failed to create"
                            });
                        }
                    }
                });
            });
        })
    </script>
@endsection
