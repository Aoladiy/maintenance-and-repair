@extends('index')
@section('createButton')
    <button class="btn btn-secondary create-item-btn" data-parent-id=null data-bs-toggle="modal"
            data-bs-target="#createEquipmentModal">
        Создать оборудование
    </button>
@endsection
@section('address')
    <strong>Адрес: <a href="{{route('sites')}}?name={{$site->name}}">{{$site->name}}</a></strong>
@endsection
@section('modals')
    @include('./modals/equipment/modal_details')
    @include('./modals/equipment/modal_create')
    @include('./modals/equipment/modal_edit')
    @include('./modals/modal_alertable_edit')
    @include('./modals/modal_serviceable_edit')
@endsection
@section('scripts')
    <script src="{{asset('js/equipment.js')}}"></script>
@endsection
