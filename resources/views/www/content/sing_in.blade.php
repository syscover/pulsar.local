@extends('www.layouts.default')

@section('title', 'HOME')

@section('head')
@stop

@section('content')
    <h1>Sing In</h1>
    <form action="{{ route('postSingIn-' . user_lang()) }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="active" value="1"> <!-- set customer created like active -->
        <div class="form-group">
            <label for="name">Name</label>
            <select class="form-control" name="groupId" required>
                <option value="">Select a customer group</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id_300 }}">{{ $group->name_300 }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
        </div>
        <div class="form-group">
            <label for="surname">Surname</label>
            <input type="text" class="form-control" id="surname" name="surname" placeholder="Surname" required>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
            <label for="repassword">Repeat Password</label>
            <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Password" required>
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button type="submit" class="btn btn-default">Sing In</button>
    </form>
@stop