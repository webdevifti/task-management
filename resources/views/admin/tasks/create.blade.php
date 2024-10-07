@extends('layouts.master')
@section('title', 'Create A Task')
@section('styles')
    <style>
        .dropzone-wrapper {
            border: 2px dashed #91b0b3;
            color: #92b0b3;
            position: relative;
            height: 150px;
            background-color: #eee;
        }

        .dropzone-desc {
            position: absolute;
            margin: 0 auto;
            left: 0;
            right: 0;
            text-align: center;
            width: 40%;
            top: 50px;
            font-size: 16px;
        }

        .dropzone,
        .dropzone:focus {
            position: absolute;
            outline: none !important;
            width: 100%;
            height: 150px;
            cursor: pointer;
            opacity: 0;
        }

        .dropzone-wrapper:hover,
        .dropzone-wrapper.dragover {
            background: #ecf0f5;
        }
    </style>
@endsection
@section('main_content')
    <main id="main" class="main">

        <div class="pagetitle">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1>Create A Task</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Create Task</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.manage-tasks.index') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-arrow-left"></i></a>
            </div>

        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="card p-2">
                    <div class="card-body">
                        <form id="taskForm" enctype="multipart/form-data">

                            <div class="mb-2">
                                <label for=""><strong>Title</strong></label>
                                <input type="text" name="title" placeholder="Title" value="{{ old('title') }}"
                                    class="form-control" required>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for=""><strong>Description</strong></label>
                                <textarea cols="30" rows="5" name="description" placeholder="Description" class="form-control" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for=""><strong>Assigned to</strong></label>
                                <select name="assigned_to" class="form-control" id="">
                                    <option value="">--select user--</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="due_date"><strong>Due Date</strong></label>
                                <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
                            </div>
                            <div class="mb-2">
                                <label for=""><strong>Status</strong></label><br>

                                <input type="radio" name="status" value="Pending" id="Pending">
                                <label for="Pending">Pending</label>
                                <input type="radio" name="status" value="In Progress" id="In Progress">
                                <label for="In Progress">In Progress</label>
                                <input type="radio" name="status" value="Completed" id="Completed">
                                <label for="Completed">Completed</label>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <label for=""><strong>Image (Optional)</strong></label>
                            <small>supported [jpg,png,jpeg,pdf] max-size: 2MB</small>
                            <div class="mb-3">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <div class="dropzone-wrapper">
                                    <div class="dropzone-desc">
                                        <i class="bi bi-cloud-upload-fill"></i>
                                        <p>Choose an image file or drag it here.</p>
                                        <p class="file-count mt-2">No file selected</p>

                                    </div>

                                    <input type="file" name="image" accept="image/png, image/jpg, image/jpeg"
                                        class="dropzone">
                                </div>
                                <button type="button" class="btn btn-danger btn-sm remove d-none text-center"
                                    onclick="resetInput()">Remove</button>
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
            $('#taskForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/admin/manage-tasks",
                    method: 'POST',
                    data: formData,

                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#taskForm')[0].reset();
                            iziToast.success({
                                position: 'topRight',
                                message: "Task has been added."
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
                                message: "Failed to add"
                            });
                        }
                    }
                });
            });

            function readFile(input) {
                if (input.files && input.files.length > 0) {
                    var wrapperZone = $(input).parent();
                    var previewZone = wrapperZone.parent().find('.preview-zone');
                    var fileCountDisplay = wrapperZone.parent().find('.file-count');
                    var resetButton = wrapperZone.parent().find('.remove');

                    wrapperZone.removeClass('dragover');

                    var totalFiles = input.files.length;
                    fileCountDisplay.text(totalFiles + ' file(s) selected');

                    resetButton.removeClass('d-none');
                } else {
                    var fileCountDisplay = $(input).parent().parent().find('.file-count');
                    fileCountDisplay.text('No files selected');
                }
            }

            function resetInput() {
                var fileInput = $(".dropzone");
                var resetButton = $(".remove");
                fileInput.val('');
                var fileCountDisplay = $('.file-count');
                fileCountDisplay.text('No files selected');
                resetButton.addClass('d-none');
            }

            $(".dropzone").change(function() {
                readFile(this);
            });

            $('.dropzone-wrapper').on('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragover');
            });

            $('.dropzone-wrapper').on('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
            });
        })
    </script>
@endsection
