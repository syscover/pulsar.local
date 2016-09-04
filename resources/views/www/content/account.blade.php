@extends('www.layouts.default')

@section('title', 'My Account')

@section('head')
@stop

@section('content')
    <h1>My Account</h1>
    <form action="{{ route('putSingIn-' . user_lang()) }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="active" value="1"> <!-- set customer created like active -->
        <input type="hidden" name="id" value="{{ $customer->id_301 }}">
        <div class="form-group">
            <label for="name">Name</label>
            <select class="form-control" name="groupId" required>
                <option value="">Select a customer group</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id_300 }}" @if($group->id_300 == $customer->group_id_301) selected @endif>{{ $group->name_300 }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $customer->name_301 }}" placeholder="Name" required>
        </div>
        <div class="form-group">
            <label for="surname">Surname</label>
            <input type="text" class="form-control" id="surname" name="surname" value="{{ $customer->surname_301 }}" placeholder="Surname" required>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $customer->email_301 }}" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="repassword">Repeat Password</label>
            <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Password">
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
        <button type="submit" class="btn btn-default">Update</button>
    </form>
@stop