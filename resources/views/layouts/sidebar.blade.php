<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        @if(admin_logged_in())
        <li class="nav-item">
            <a class="nav-link collapsed {{ Route::currentRouteName() == 'admin.dashboard' ? 'active':'' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
      
        <li class="nav-item">
            <a class="nav-link collapsed {{ Route::currentRouteName() == 'admin.manage-tasks.index' ? 'active':'' }}" href="{{ route('admin.manage-tasks.index') }}">
                <i class="ri-ticket-2-fill"></i>
                <span>Tasks</span>
            </a>
        </li>
      
        <li class="nav-item">
            <a class="nav-link collapsed {{ Route::currentRouteName() == 'admin.manage-users.index' ? 'active':'' }}" href="{{ route('admin.manage-users.index') }}">
                <i class="ri-file-user-fill"></i>
                <span>Users</span>
            </a>
        </li>
        @endif

        @if(user_logged_in())
        <li class="nav-item">
            <a class="nav-link collapsed {{ Route::currentRouteName() == 'user.dashboard' ? 'active':'' }}" href="{{ route('user.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{ Route::currentRouteName() == 'user.tasks.index' ? 'active':'' }}" href="{{ route('user.tasks.index') }}">
                <i class="ri-ticket-2-fill"></i>
                <span>My Tasks</span>
            </a>
        </li>
        @endif
    </ul>

</aside>
