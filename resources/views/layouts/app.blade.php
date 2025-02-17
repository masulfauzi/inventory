<!DOCTYPE html>
<html lang="en" dir="theme-light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} | {{ @$title ?? 'Dashboard' }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tempus-dominus.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/base.min.css"/> --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.5/css/selectize.bootstrap5.min.css" />

    <script src="{{ asset('assets/js/sweetalert.js') }}"></script>
    <style>
        .ck-editor__editable {
            min-height: 300px;
        }
    </style>
    @yield('page-css')
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('frontend.index') }}">
                            <h5 class="mb-0"> <i class="bi bi-tornado"></i> {{ config('app.name') }}</h5>
                        </a>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--mdi" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                </path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i
                                    class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                @include('parts.sidebar')
            </div>
        </div>
        <div id="main" class='layout-navbar'>
            <header class=''>
                <nav class="navbar navbar-expand navbar-light ">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            @if (get('active_role') == 'Super Admin')


                                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                    <li class="nav-item dropdown me-1">
                                        <a class="nav-link active dropdown-toggle text-gray-700 me-3" href="#"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="badge bg-success fs-6"> <i class='bi bi-person-lines-fill'></i>
                                                {{ session('active_gudang')['nama_gudang'] }} </span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <h6 class="dropdown-header">Pilih Gudang</h6>
                                            </li>
                                            @foreach (session('gudang') as $key => $item)
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ session('active_gudang')['id'] == $key ? '#' : route('dashboard.change.gudang', $key) }}">
                                                        @if (session('active_gudang')['id'] == $key)
                                                            <b>{{ $item }}<i class="bi bi-check"></i></b>
                                                        @else
                                                            {{ $item }}
                                                        @endif
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            @endif
                            @if (get('active_role') == 'Super Admin')
                                <ul class="navbar-nav mb-2 mb-lg-0">
                                @else
                                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            @endif
                            <li class="nav-item dropdown me-1">
                                <a class="nav-link active dropdown-toggle text-gray-700 me-3" href="#"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="badge bg-primary fs-6"> <i class='bi bi-person-lines-fill'></i>
                                        {{ get('active_role') }} </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <h6 class="dropdown-header">Available Role(s)</h6>
                                    </li>
                                    @foreach (session('roles') as $key => $item)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ get('active_role') == $item ? '#' : route('dashboard.change.role', $key) }}">
                                                @if (get('active_role') == $item)
                                                    <b>{{ $item }}<i class="bi bi-check"></i></b>
                                                @else
                                                    {{ $item }}
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            </ul>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-name text-end me-3">
                                            <h6 class="mb-0 text-gray-700">{{ Auth::user()->name }}</h6>
                                            <p class="mb-0 text-sm text-gray-700">{{ get('active_role') }}</p>
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md bg-primary">
                                                <div class="avatar-content">
                                                    {{ Auth::user()->initials() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                                    style="min-width: 11rem;">
                                    <li>
                                        <h6 class="dropdown-header">Hello, {{ Auth::user()->name }}</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#"><i
                                                class="icon-mid bi bi-person me-2"></i> My Profile</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('dashboard.change.role', get('active_role_id')) }}"><i
                                                class="icon-mid bi bi-arrow-clockwise me-2"></i> Flush Session</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button class="dropdown-item"
                                                onclick="event.preventDefault();this.closest('form').submit();">
                                                <i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <hr class="m-0">
            </header>
            <div id="main-content">
                @yield('main')
                <footer>
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>{{ date('Y') }} &copy; {{ config('app.name') }}</p>
                        </div>
                        <div class="float-end">
                            <p>Crafted with <span class=""><i class="bi bi-tornado"></i> Inventory System</span>
                                by <a href="https://smkn2semarang.sch.id/">Skanida</a></p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="{{ asset('assets/js/app.js') }}"></script>
        {{-- <script src="{{ asset('assets/js/select2.js') }}"></script> --}}
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/mine.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/tempus-dominus.js') }}"></script>
        <script src="{{ asset('assets/js/moment.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.5/js/standalone/selectize.min.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
        <script>
            $(".select2").selectize();
            var $selectizeObj = $(".multi-select2").selectize({
                maxItems: null
            });

            $(function() {

                // wisiwig
                richs = document.querySelectorAll('.rich-editor');
                richs.forEach(element => {
                    ClassicEditor.create(element);
                });

                // datepicker
                loadDatePicker('.datetimepicker');
                loadDatePicker('.datepicker');
            });
            document.addEventListener('DOMContentLoaded', function() {
                if (localStorage.getItem('theme') === 'dark') {
                    document.body.classList.add('theme-dark');
                }
            });
        </script>
        @yield('page-js')
        @yield('inline-js')
</body>

</html>
