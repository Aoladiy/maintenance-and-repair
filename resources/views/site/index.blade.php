@extends('index')
@section('createButton')
    <button class="btn btn-secondary create-item-btn" data-parent-id=null data-bs-toggle="modal"
            data-bs-target="#createSiteModal">
        Создать участок
    </button>
@endsection
@section('modals')
    @include('./modals/site/modal_details')
    @include('./modals/site/modal_create')
    @include('./modals/site/modal_edit')
@endsection
@section('scripts')
    <script src="{{asset('js/site.js')}}"></script>
@endsection
