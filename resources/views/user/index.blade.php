@extends('layouts.master')
@section('title','Dashboard')
@section('main_content')
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>
    <section class="section dashboard">
      <div class="row">

        <div class="col-lg-12">
          <div class="row">

          
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">My Tasks</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="ri-ticket-2-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{$total_task}}</h6>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <div class="col-xxl-4 col-md-6">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">Completed Tasks</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon  rounded-circle text-success d-flex align-items-center justify-content-center">
                      <i class="ri-ticket-2-fill "></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{$total_completed_tickets}}</h6>
                     </div>
                  </div>

                </div>
              </div>

            </div>
            <div class="col-xxl-4 col-md-6">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">Pending Tasks</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="ri-ticket-2-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{$total_pending_tickets}}</h6>
                     </div>
                  </div>

                </div>
              </div>

            </div>
            <div class="col-xxl-4 col-md-6">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">In Progress Tasks</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon text-warning rounded-circle d-flex align-items-center justify-content-center">
                      <i class="ri-ticket-2-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{$total_progress_tickets}}</h6>
                     </div>
                  </div>

                </div>
              </div>

            </div>

          </div>
        </div>

      </div>
    </section>

  </main>
@endsection
  