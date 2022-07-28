@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header p-3 pt-2">
            <div
                class="icon icon-lg icon-shape bg-gradient-primary shadow text-center border-radius-xl mt-n4 me-3 float-start">
                <i class="material-icons opacity-10">edit</i>
            </div>
            <h6 class="mb-0">@lang('form.edit') @lang('role.role')</h6>
        </div>
        <div class="card-body pt-2">
            <form method="POST" action="{{ route('roles.update',[$role->id]) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group input-group-static">
                            <label>@lang('role.name') *</label>
                            <input type="text" class="form-control" name="name" max="200" autofocus
                                   value="{{ $role->name }}" autocomplete="nope" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @foreach($vars as $label => $envs)
                            <div class="card border border-primary">
                                <div class="card-header p-2">
                                    <h4 class="mb-0"><strong>{{ __('menu.'.$label) }}</strong></h4>
                                </div>
                                <div class="card-body p-2">
                                    <div class="table-responsive-sm">
                                        <table class="table">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>@lang('role.environment')</th>
                                                <th>@lang('role.enabled')</th>
                                                <th>@lang('role.insert')</th>
                                                <th>@lang('role.update')</th>
                                                <th>@lang('role.delete')</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($envs as $key => $env)
                                                <tr>

                                                    <td>{{ __('permission.'.$key) }}</td>

                                                    <td class="td-checkbox">
                                                        <div class="row">
                                                            <div class="col-md-12 left-checkbox">
                                                                <input type="checkbox"
                                                                       id="{{$key}}" class="env_check"
                                                                       style="width: 20px;height: 20px;" name="permissions[]"
                                                                       @if($role->hasPermissionTo($env->where('name', \App\Helpers\Acl::OPERATION_R.'_'.$key)->first()->id))
                                                                       checked
                                                                       @endif
                                                                       value="{{$env->where('name', \App\Helpers\Acl::OPERATION_R.'_'.$key)->first()->id}}">
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="td-checkbox">
                                                        @if($env->where('name', \App\Helpers\Acl::OPERATION_C.'_'.$key)->count() > 0)
                                                            <div class="row">
                                                                <div class="col-md-12 left-checkbox">
                                                                    <input type="checkbox"
                                                                           class="check_{{$key}}"
                                                                           style="width: 20px;height: 20px;" name="permissions[]"
                                                                           @if($role->hasPermissionTo($env->where('name', \App\Helpers\Acl::OPERATION_R.'_'.$key)->first()->id))
                                                                           @if($role->hasPermissionTo($env->where('name', \App\Helpers\Acl::OPERATION_C.'_'.$key)->first()->id))
                                                                           checked
                                                                           @endif
                                                                           @else
                                                                           disabled
                                                                           @endif
                                                                           value="{{$env->where('name', \App\Helpers\Acl::OPERATION_C.'_'.$key)->first()->id}}">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </td>

                                                    <td class="td-checkbox">
                                                        @if($env->where('name', \App\Helpers\Acl::OPERATION_U.'_'.$key)->count() > 0)
                                                            <div class="row">
                                                                <div class="col-md-12 left-checkbox">
                                                                    <input type="checkbox"
                                                                           class="check_{{$key}}"
                                                                           style="width: 20px;height: 20px;" name="permissions[]"
                                                                           @if($role->hasPermissionTo($env->where('name', \App\Helpers\Acl::OPERATION_R.'_'.$key)->first()->id))
                                                                           @if($role->hasPermissionTo($env->where('name', \App\Helpers\Acl::OPERATION_U.'_'.$key)->first()->id))
                                                                           checked
                                                                           @endif
                                                                           @else
                                                                           disabled
                                                                           @endif
                                                                           value="{{$env->where('name', \App\Helpers\Acl::OPERATION_U.'_'.$key)->first()->id}}">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </td>

                                                    <td class="td-checkbox">
                                                        @if($env->where('name', \App\Helpers\Acl::OPERATION_D.'_'.$key)->count() > 0)
                                                            <div class="row">
                                                                <div class="col-md-12 left-checkbox">
                                                                    <input type="checkbox"
                                                                           class="check_{{$key}}"
                                                                           style="width: 20px;height: 20px;" name="permissions[]"
                                                                           @if($role->hasPermissionTo($env->where('name', \App\Helpers\Acl::OPERATION_R.'_'.$key)->first()->id))
                                                                           @if($role->hasPermissionTo($env->where('name', \App\Helpers\Acl::OPERATION_D.'_'.$key)->first()->id))
                                                                           checked
                                                                           @endif
                                                                           @else
                                                                           disabled
                                                                           @endif
                                                                           value="{{$env->where('name', \App\Helpers\Acl::OPERATION_D.'_'.$key)->first()->id}}">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('roles.index') }}" class="btn btn-dark m-0">@lang('form.back')</a>
                    <button class="btn bg-gradient-primary m-0 ms-2">@lang('form.save')</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            $(document).on('click', '.check_permission', function (e) {

                let env = e.target.classList[1].split('_')[e.target.classList[1].split('_').length - 1];

                let elements = document.getElementsByClassName('check_' + env);

                let bools = [];
                $.each(elements, function (key, value) {
                    bools.push(value.checked);
                });

                let allFalse = arr => arr.every(v => v === false);
                document.getElementById(env).checked = !allFalse(bools);

            });

            $(document).on('click', '.env_check', function (e) {

                let env = e.target.id;
                let element = document.getElementById(env);

                if (!env.checked) {
                    let elements = document.getElementsByClassName('check_' + env);
                    $.each(elements, function (key, value) {
                        value.checked = false;
                        value.disabled = !element.checked;
                    });
                }

            });

        });
    </script>
@endpush

