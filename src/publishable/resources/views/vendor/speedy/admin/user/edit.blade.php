@extends('vendor.speedy.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('vendor.speedy.partials.alert')
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('view.admin.public.' . (isset($user) ? 'edit' : 'create')) . ' ' . trans('view.admin.user.title') }}</div>
                    <form method="post" action="{{ isset($user) ? route('admin.user.update', ['id' => $user->id]) :  route('admin.user.store') }}">
                        <div class="panel-body">
                            {{ csrf_field() }}
                            {{ isset($user) ? method_field('PUT') : '' }}
                            <div class="form-group">
                                <label>{{ trans('view.admin.user.name') }}</label>
                                <input type="text" name="name" class="form-control" placeholder="{{ trans('view.admin.user.name') }}" value="{{ isset($user) ? $user->name : '' }}">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('view.admin.user.email') }}</label>
                                <input type="email" name="email" class="form-control" placeholder="{{ trans('view.admin.user.email') }}" value="{{ isset($user) ? $user->email : '' }}">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('view.admin.user.password') }}</label>
                                <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="{{ trans('view.admin.user.password') }}">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('view.admin.user.role') }}</label>
                                <select name="role_id" class="form-control">
                                    <option value="">{{ trans('view.admin.public.none') }}</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ isset($user) ? ($role->id === $user->role_id ? 'selected' : '') : '' }}>{{ $role->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="panel-footer"><button type="submit" class="btn btn-primary">{{ trans('view.admin.public.submit') }}</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection