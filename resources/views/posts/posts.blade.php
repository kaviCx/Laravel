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
                    <div class="col-md-11 d-flex align-items-center">
                        <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                            <img src="https://img.icons8.com/?size=100&id=2797&format=png&color=000000" alt="Logo"
                                width="30">
                        </a>
                        <h5 class="ms-3">Dashboard</h5>
                    </div>
                    <div class="col-md-1 d-flex align-items-center justify-content-end">
                        <a class="btn btn-link text-decoration-none" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('posts') }}" method="GET" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <input type="text" class="form-control rounded" name="search" placeholder="Search"
                                aria-label="Search" aria-describedby="search-addon" />
                        </div>
                        <div class="col-md-3">
                            <select class="form-select bg-light" aria-label="Default select example" name="category">
                                <option selected disabled>Choose Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-outline-primary w-100">Search</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('post.create') }}" class="btn btn-primary">Add Post</a>
                        </div>

                    </form>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Post Title</th>
                                <th class="text-center" scope="col">Category Name</th>
                                <th class="text-center" scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td class="text-center">{{ $post->category->name }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-sm"
                                            href="{{ route('post.edit', $post->id) }}">Edit</a>
                                        <form action="{{ route('post.delete', $post->id) }}" method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm ms-2">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

</body>

</html>
