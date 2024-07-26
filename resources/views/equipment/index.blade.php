@extends('index')
@section('address')
    <strong>Адрес: <a href="{{route('sites')}}?name={{$site->name}}">{{$site->name}}</a></strong>
@endsection
@section('modals')
    <!-- Модальное окно просмотра подробностей -->
    @include('./modals/equipment/modal_details')

    <!-- Модальное окно для создания нового элемента -->
    @include('./modals/equipment/modal_create')

    <!-- Модальное окно для редактирования элемента -->
    @include('./modals/equipment/modal_edit')
@endsection
@section('scripts')
    <script src="{{asset('js/equipment.js')}}"></script>
@endsection
