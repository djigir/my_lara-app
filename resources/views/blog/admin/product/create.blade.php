@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('blog.admin.components.breadcrumb')
            @slot('title') Добавление товара @endslot
            @slot('parent') Главная @endslot
            @slot('product') Список заказаов @endslot
            @slot('active') Новый товар @endslot
        @endcomponent
    </section>

    <!-- -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form method="POST" action="{{ route('blog.admin.products.store', $item->id) }}" data-toggle="validator" id="add">
                        @csrf

                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Наименование товара</label>
                                <input type="text" name="title" class="form-control" id="title" placeholder="Наименование товара" value="{{old('title')}}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group">
                                <select name="parent_id" id="parent_id" class="form-control" required>
                                    <option>--  выбирете категорию --</option>

                                    @include('blog.admin.category.include.edit_categories_all_list', ['categories' => $categories])
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="keywords">Ключевые слова</label>
                                <input type="text" name="keywords" id="keywords" class="form-control" placeholder="Ключевые слова" value="{{old('keywords')}}">
                            </div>

                            <div class="form-group">
                                <label for="description">Описание</label>
                                <input type="text" name="description" id="description" class="form-control" placeholder="Описание" value="{{old('description')}}">
                            </div>

                            <div class="form-group has-feedback">
                                <label for="price">Цена</label>
                                <input type="text" name="price" class="form-control" id="price" placeholder="Цена" pattern="[0-9.]{1,}$" value="{{old('price')}}" required data-error="Допускаються цифры и десятичная точка">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="old_price">Старая Цена</label>
                                <input type="text" name="old_price" class="form-control" id="old_price" placeholder="Старая Цена" pattern="[0-9.]{1,}$" value="{{old('old_price')}}" required data-error="Допускаються цифры и десятичная точка">
                                <div class="help-block with-errors"></div>
                            </div>
                            
                            <div class="form-group has-feedback">
                                <label for="editor1">Контент</label>
                                <textarea name="content" id="editor1" cols="80" rows="10">{{old('content')}}</textarea>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="status" checked> Статус
                                </label>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="hit"> Хит
                                </label>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="related">Связаные товары</label>
                                <p><small>Начните вводить наименование товара</small></p>
                                <select name="related[]" class="select2 form-control" id="related" multiple>

                                </select>
                            </div>


                            <div class="form-group">
                                <label>Фильтры продуктов</label>
                                {{ Widget::run('filter', ['tpl' => 'widgets.filter', 'filter' => null]) }}
                            </div>


                            <div class="form-group">
                                <div class="col-md-4">
                                    @include('blog.admin.product.include.image_single_create')
                                </div>
                                <div class="col-md-8">
                                    @include('blog.admin.product.include.image_gallery_create')
                                </div>
                            </div>

                        </div>
                        <input type="hidden" id="_token" value="{{csrf_token()}}">

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.conatent -->

@endsection