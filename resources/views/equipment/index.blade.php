@extends('index')
@section('address')
    <strong><a href="{{route('sites.show', $site->id)}}">{{$site->name}}</a></strong>
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
