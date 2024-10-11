@extends('index')
@section('createButton')
    <button class="btn btn-secondary create-item-btn" data-parent-id=null data-bs-toggle="modal"
            data-bs-target="#createComponentModal">
        Создать деталь
    </button>
@endsection
@section('address')
    <strong>Адрес: <a href="{{route('sites')}}?name={{$site->name}}">{{$site->name}}</a> > <a href="{{route('equipment.bySite', $site->id)}}?name={{$equipment->name}}?inventory_number={{$equipment->inventory_number}}">{{$equipment->name}}</a> > <a href="{{route('nodes.byEquipment', $equipment->id)}}?name={{$node->name}}">{{$node->name}}</a></strong>
@endsection
@section('modals')
    @include('./modals/component/modal_details')
    @include('./modals/component/modal_create')
    @include('./modals/component/modal_edit')
    @include('./modals/modal_alertable_edit')
    @include('./modals/modal_serviceable_edit')
    @include('./modals/modal_maintenance_create')
@endsection
@section('scripts')
    <script src="{{asset('js/component.js')}}"></script>
@endsection
