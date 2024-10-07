@extends('layouts.master')
@section('title', 'User')
@section('main_content')
    <main id="main" class="main">

        <div class="pagetitle">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1>{{$user->name}}</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.manage-users.index') }}">User</a></li>
                            <li class="breadcrumb-item active">{{$user->name}}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.manage-users.index') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-arrow-left"></i></a>
                   
                </div>
            </div>

        </div>

        <section class="section dashboard">
            <div class="row">

                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body p-2">
                           
                            <h3 class="card-title">{{ $user->name }}</h3>
                            <p>{{ $user->email }}</p>
                           
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                @if ($user->tasks->count() > 0)
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Assigned to</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Due Date</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->tasks as $item)
                                        <tr>
                                            <td><a
                                                    href="{{ route('admin.manage-tasks.show', $item->id) }}">#{{ $item->task_number }}</a>
                                            </td>
                                            <td>{{$item->user?->name}}</td>
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
                                          
                                        </tr>
                                    @endforeach
    
                                </tbody>
                            @else
                                <div class="card">
                                    <div class="card-body p-2">
                                        <h3 class="card-title text-center ">This User's Has No Task Found</h3>
                                    </div>
                                </div>
                            @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    {{-- Status Confirm --}}
   
@endsection