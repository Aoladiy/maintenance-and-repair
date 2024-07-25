@extends('index')
@section('modals')
    <!-- Модальное окно просмотра подробностей -->
    @include('./modals/site/modal_details')

    <!-- Модальное окно для создания нового элемента -->
    @include('./modals/site/modal_create')

    <!-- Модальное окно для редактирования элемента -->
    @include('./modals/site/modal_edit')
@endsection
@section('scripts')
    <script src="{{asset('js/site.js')}}"></script>
@endsection
