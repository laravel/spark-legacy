@extends('spark::layouts.app')

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mousetrap/1.4.6/mousetrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
@endsection

@section('content')
<spark-kiosk :user="user" inline-template>
    <div class="spark-screen container">
        <div class="row">
            <!-- Tabs -->
            <div class="col-md-3 spark-settings-tabs">
                <aside>
                    <h3 class="nav-heading ">
                        {{__('Kiosk')}}
                    </h3>
                    <ul class="nav flex-column mb-4 ">
                        <li class="nav-item ">
                            <a class="nav-link" href="#announcements" aria-controls="announcements" role="tab" data-toggle="tab">
                                <svg class="icon-20 " viewBox="0 0 20 20 " xmlns="http://www.w3.org/2000/svg ">
                                    <path d="M10 20C4.4772 20 0 15.5228 0 10S4.4772 0 10 0s10 4.4772 10 10-4.4772 10-10 10zm0-17C8.343 3 7
              4.343 7 6v2c0 1.657 1.343 3 3 3s3-1.343 3-3V6c0-1.657-1.343-3-3-3zM3.3472 14.4444C4.7822 16.5884 7.2262 18 10
              18c2.7737 0 5.2177-1.4116 6.6528-3.5556C14.6268 13.517 12.3738 13 10 13s-4.627.517-6.6528 1.4444z "></path>
                                </svg>
                                {{__('Announcements')}}
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="#metrics" aria-controls="metrics" role="tab" data-toggle="tab">
                                <svg class="icon-20 " viewBox="0 0 20 20 " xmlns="http://www.w3.org/2000/svg ">
                                    <path d="M6 8C4 8 2 6.2 2 4s2-4 4-4c2.3 0 4 1.8 4 4S8.4 8 6 8zm0 1c2.3 0 4.3.4 6.2 1l-1 6H9.8l-1 4H3l-.6-4H1l-1-6c2-.6
              4-1 6-1zm8.4.2c1.3 0 2.6.4 3.8 1l-1 5.8H16l-1 4h-4l.4-2h1.3l1.6-8.8zM12 0c2.3 0 4 1.8 4 4s-1.7 4-4 4c-.4 0-.8
              0-1.2-.2.8-1 1.3-2.4 1.3-3.8s0-2.7-1-3.8l1-.2z " />
                                </svg>
                                {{__('Metrics')}}
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="#users" aria-controls="users" role="tab" data-toggle="tab">
                                <svg class="icon-20 " viewBox="0 0 20 20 " xmlns="http://www.w3.org/2000/svg ">
                                    <path d="M3 8V6c0-3.3 2.7-6 6-6s6 2.7 6 6v2h1c1 0 2 1 2 2v8c0 1-1 2-2 2H2c-1 0-2-1-2-2v-8c0-1 1-2 2-2h1zm5
              6.7V17h2v-2.3c.6-.3 1-1 1-1.7 0-1-1-2-2-2s-2 1-2 2c0 .7.4 1.4 1 1.7zM6 6v2h6V6c0-1.7-1.3-3-3-3S6 4.3 6 6z "/>
                                </svg>
                                {{__('Users')}}
                            </a>
                        </li>
                    </ul>
                </aside>
            </div>

            <!-- Tab cards -->
            <div class="col-md-9">
                <div class="tab-content">
                    <!-- Announcements -->
                    <div role="tabcard" class="tab-pane active" id="announcements">
                        @include('spark::kiosk.announcements')
                    </div>

                    <!-- Metrics -->
                    <div role="tabcard" class="tab-pane" id="metrics">
                        @include('spark::kiosk.metrics')
                    </div>

                    <!-- User Management -->
                    <div role="tabcard" class="tab-pane" id="users">
                        @include('spark::kiosk.users')
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-kiosk>
@endsection
