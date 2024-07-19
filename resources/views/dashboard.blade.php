<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 11 Dashboard Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
</head>

<body>

    <main>
        <div class="container py-4">
            <header class="pb-3 mb-4 border-bottom">
                <div class="row">
                    <div class="col-md-11 flex flex-row">
                        <div>
                            <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                                <img src="https://img.icons8.com/?size=100&id=2797&format=png&color=000000"
                                    alt=" Logo" width="30">
                            </a>
                        </div>
                        <div>
                            <h5>Dashboard</h5>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="GET" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>

            </header>

            <div class="p-5 mb-4 bg-light rounded-3">
                <div class="container-fluid py-5">

                    @session('success')
                        <div class="alert alert-success" role="alert">
                            {{ $value }}
                        </div>
                    @endsession

                    <h1 class="display-5 fw-bold">Hi, {{ auth()->user()->name }}</h1>
                    <p class="col-md-8 fs-4">Welcome to dashboard</p>
                    <button class="btn btn-primary btn-lg" type="button">Dashboard</button>
                </div>
            </div>

        </div>
    </main>

</body>

</html>
