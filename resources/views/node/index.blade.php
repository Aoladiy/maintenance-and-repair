@extends('index')
@section('createButton')
    <button class="btn btn-secondary create-item-btn" data-parent-id=null data-bs-toggle="modal"
            data-bs-target="#createNodeModal">
        Создать узел
    </button>
@endsection
@section('address')
    <strong>Адрес: <a href="{{route('sites')}}?name={{$site->name}}">{{$site->name}}</a> > <a href="{{route('equipment.bySite', $site->id)}}?name={{$equipment->name}}?inventory_number={{$equipment->inventory_number}}">{{$equipment->name}}</a></strong>
@endsection
@section('modals')
    @include('./modals/node/modal_details')
    @include('./modals/node/modal_create')
    @include('./modals/node/modal_edit')
    @include('./modals/modal_alertable_edit')
    @include('./modals/modal_serviceable_edit')
@endsection
@section('scripts')
    <script src="{{asset('js/node.js')}}"></script>
@endsection
