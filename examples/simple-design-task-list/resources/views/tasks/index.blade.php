@php
  /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
  /** @var App\Models\Eloquents\Task $task */
@endphp

@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="col-sm-offset-2 col-sm-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          New Task
        </div>

        <div class="panel-body">
          <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New Task Form -->
          <form action="{{ url('task') }}" method="POST" class="form-horizontal">
          {{ csrf_field() }}

          <!-- Task Name -->
            <div class="form-group">
              <label for="task-name" class="col-sm-3 control-label">Task</label>

              <div class="col-sm-6">
                <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">
              </div>
            </div>

            <!-- Add Task Button -->
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                  <i class="fa fa-btn fa-plus"></i>Add Task
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Current Tasks -->
      @if (count($paginator) > 0)
        <div class="panel panel-default">
          <div class="panel-heading">
            Current Tasks
          </div>

          <div class="panel-body">
            <table class="table table-striped task-table">
              <thead>
              <th><a href="{{ sort_uri(request(), 'id')}}">id</a></th>
              <th><a href="{{ sort_uri(request(), 'name')}}">name</a></th>
              <th><a href="{{ sort_uri(request(), 'created_at')}}">created_at</a></th>
              </thead>
              <tbody>
              @foreach ($paginator as $task)
                <tr>
                  <td class="table-text"><div>{{ $task->id }}</div></td>
                  <td class="table-text"><div>{{ $task->name }}</div></td>
                  <td class="table-text"><div>{{ $task->created_at }}</div></td>

                  <!-- Task Delete Button -->
                  <td>
                    <form action="{{url('task/' . $task->id)}}" method="POST">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}

                      <button type="submit" id="delete-task-{{ $task->id }}" class="btn btn-danger">
                        <i class="fa fa-btn fa-trash"></i>Delete
                      </button>
                    </form>
                  </td>
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
@endsection