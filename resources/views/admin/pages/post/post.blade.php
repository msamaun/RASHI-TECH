@extends('admin.layouts.sidenav-layout')
@section('content')
    @include('admin.components.post.post-list')
    @include('admin.components.post.post-delete')
    @include('admin.components.post.post-create')
    @include('admin.components.post.post-update')
@endsection



