@php
  /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
  /** @var App\Models\Eloquents\User $user */
@endphp

@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="col-sm-offset-2 col-sm-8">
      <div class="panel panel-default">
        <div class="panel-body">
          @include('common.errors')

          @if (count($paginator) > 0)
          <div class="panel panel-default">
            <div class="panel-heading">
              Users
            </div>

            <div class="panel-body">
              <table class="table table-striped task-table">
                <thead>
                <th><a href="{{ sort_uri(request(), 'id')}}">id</a></th>
                <th><a href="{{ sort_uri(request(), 'name')}}">name</a></th>
                <th><a href="{{ sort_uri(request(), 'email')}}">email</a></th>
                <th><a href="{{ sort_uri(request(), 'created_at')}}">created_at</a></th>
                <th><a href="{{ sort_uri(request(), 'updated_at')}}">updated_at</a></th>
                </thead>
                <tbody>
                @foreach ($paginator as $user)
                  <tr>
                    <td class="table-text"><div>{{ $user->id }}</div></td>
                    <td class="table-text"><div>{{ $user->name }}</div></td>
                    <td class="table-text"><div>{{ $user->email }}</div></td>
                    <td class="table-text"><div>{{ $user->created_at }}</div></td>
                    <td class="table-text"><div>{{ $user->updated_at }}</div></td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div>
            {{ $paginator->links() }}
          </div>
        @endif
        </div>
      </div>
    </div>
  </div>
@endsection