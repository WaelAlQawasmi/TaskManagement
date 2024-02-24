@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col" width="1%">#</th>
            <th scope="col" width="15%">title</th>
            <th scope="col">description</th>
            <th scope="col" width="10%">assign user</th>
            <th scope="col" width="10%"> user crator</th>
        </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <th scope="row">{{ $task->id }}</th>
                    <td>{{ $task->title }}</td>
                    <td>{{  $task->description   }}</td>
                    <td>{{  $task->assignedUser? $task->assignedUser->name : null  }}</td>
                    <td>{{   $task->creatorUser->name   }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex">
        {!! $tasks->links() !!}
    </div>
</div>
@endsection
