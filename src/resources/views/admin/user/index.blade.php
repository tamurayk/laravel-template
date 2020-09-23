@php
/** @var App\Models\Eloquents\User[] $users*/
@endphp

@extends('layouts.admin')
@section('content')
  <h1>users</h1>
  <div>
    <table>
      <thead>
      <tr>
        <th colspan="3">Users</th>
      </tr>
      <tr>
        <th>id</th>
        <th>name</th>
        <th>email</th>
        <th>created_at</th>
        <th>updated_at</th>
      </tr>
      </thead>
      <tbody>
      @if(count($users) > 0)
        @foreach($users as $user)
          <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at }}</td>
            <td>{{ $user->updated_at }}</td>
          </tr>
        @endforeach
      @else
        <tr>
          <td colspan="3">No results.</td>
        </tr>
      @endif
      </tbody>
    </table>
  </div>
@endsection
