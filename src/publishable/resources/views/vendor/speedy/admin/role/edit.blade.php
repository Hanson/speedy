@extends('vendor.speedy.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('vendor.speedy.partials.alert')
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('view.admin.public.' . (isset($role) ? 'edit' : 'create')) . ' ' . trans('view.admin.role.title') }}</div>
                    <form method="post" action="{{ isset($role) ? route('admin.role.update', ['id' => $role->id]) :  route('admin.role.store') }}">
                        <div class="panel-body">
                            {{ csrf_field() }}
                            {{ isset($role) ? method_field('PUT') : '' }}
                            <div class="form-group">
                                <label>{{ trans('view.admin.role.name') }}</label>
                                <input type="text" name="name" class="form-control" placeholder="{{ trans('view.admin.role.name') }}" value="{{ isset($role) ? $role->name : '' }}">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('view.admin.role.display_name') }}</label>
                                <input type="text" name="display_name" class="form-control" placeholder="{{ trans('view.admin.role.display_name') }}" value="{{ isset($role) ? $role->display_name : '' }}">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('view.admin.role.permission') }}</label>
                                <div class="checkbox">
                                    <?php if(isset($role)){$rolePermissions = $role->permissions->pluck('id')->toArray();}?>
                                    @foreach($permissions as $permission)
                                    <label>
                                        <input name="permission_id[]" value="{{ $permission->id }}" type="checkbox" {{ isset($rolePermissions) && in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>{{ $permission->display_name }}
                                    </label><br>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer"><button type="submit" class="btn btn-primary">{{ trans('view.admin.public.submit') }}</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection