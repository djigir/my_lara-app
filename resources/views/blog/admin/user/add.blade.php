@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('blog.admin.components.breadcrumb')
            @slot('title') Добавить пользователя @endslot
            @slot('parent') Главная @endslot
            @slot('active') Добавить пользователя @endslot
        @endcomponent
    </section>

    <!-- -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ route('blog.admin.users.store') }}" method="POST" data-toggle="validator">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="name">Имя</label>
                                <input type="text" name="name" class="form-control" id="name" required value="@if(old('name')){{old('name')}} @else @endif">

                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="password">Пароль</label>
                                <input type="text" name="password" class="form-control" id="password" required value="@if(old('password')){{old('password')}} @else @endif">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Подтверждение пароля</label>
                                <input type="text" name="password_confirmation" class="form-control" id="password_confirmation" required value="@if(old('password_confirmation')){{old('password_confirmation')}} @else @endif">

                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email" value="@if(old('email')){{old('email')}} @else @endif" required>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="role">Роль</label>
                                <select name="role" id="role">
                                    <option value="2" selected>Пользователь</option>
                                    <option value="3" selected>Админимтратор</option>
                                    <option value="1" selected>Disabled</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="hidden" name="id" value="">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
    <!-- /.content -->

@endsection