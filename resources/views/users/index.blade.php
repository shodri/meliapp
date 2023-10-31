@extends('layouts.app')

@section('content')
    <h1>List of Users</h1>

    <a class="btn btn-success mb-3" href="{{ route('products.create')}}">Create</a>

    @empty ($users)

        <div class="alert alert-warning">
            The list of users is empty
        </div>

    @else  
    
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Admin Since</th>
                <th>Actiones</th>
            </tr>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    {{ optional($user->admin_since)->diffForHumans() ?? 'Never' }}
                </td>
                <td>

                <form  class="d-inline" method="POST" action="{{ route('users.admin.toggle', ['user' => $user->id]) }}">
                    @csrf 
                    <button type="submit" class="btn btn-link">
                        {{ $user->isAdmin() ? 'Remove' : 'Make' }}
                        Admin
                    </button>
                </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    @endempty

@endsection
