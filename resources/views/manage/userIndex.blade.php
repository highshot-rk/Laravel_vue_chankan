@include("../components/head")
@extends('layouts.manage')
@section('title', '会員情報一覧')
@section('content')

<div class="content__wrap">
  <div id="app" class="content__section">
    <div class="content__header">
      <div class="content__title">
        <h1 class="h1">会員情報一覧</h1>
        <span class="en">Users List</span>
      </div>
    </div>
    <div class="tab">
      <admin-user-list-sp-component :managers="{{ $managers }}"></admin-user-list-sp-component>
    </div>
    <div class="pc">
      <admin-user-list-pc-component :managers="{{ $managers }}"></admin-user-list-pc-component>
    </div>
  </div>
</div>
@endsection




