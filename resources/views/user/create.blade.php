@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-primary shadow text-center border-radius-xl mt-n4 me-3 float-start">
                <i class="material-icons opacity-10">add</i>
            </div>
            <h6 class="mb-0">@lang('form.new') @lang('user.user')</h6>
        </div>
        <div class="card-body pt-2">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-static">
                            <label>@lang('user.lastname') *</label>
                            <input type="text" class="form-control" name="lastname" max="200" autofocus value="{{ old('lastname') }}" autocomplete="nope" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-static">
                            <label>@lang('user.name') *</label>
                            <input type="text" class="form-control" name="name" max="200" value="{{ old('name') }}" autocomplete="nope" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-static">
                            <label>@lang('user.email') *</label>
                            <input type="email" class="form-control" name="email" max="200" value="{{ old('email') }}" autocomplete="nope" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-static">
                            <label>@lang('user.password') *</label>
                            <input type="password" class="form-control" name="password" autocomplete="nope" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-control ms-0">@lang('role.role') *</label>
                        <select class="form-control choices" name="role" id="select-role" required>
                            <option value="{{ \App\Helpers\Acl::ROLE_ADMIN }}">@lang('role.administrator')</option>
                            @foreach($roles as $role)
                                <option value="{{$role->name}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('users.index') }}"  class="btn btn-dark m-0">@lang('form.back')</a>
                    <button class="btn bg-gradient-primary m-0 ms-2">@lang('form.save')</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            let selectRole = document.getElementById('select-role');
            let choicesRole = new Choices(selectRole, {
                searchEnabled: false
            })
        });
    </script>
@endpush
