@extends('templates.layout')

@section('title', 'Order Page')

@section('content')
<div class="row">
  <div class="col-8">
    @include('order.form')
  </div>
  <div class="col-4">
    @include('order.cart')
  </div>
</div>
@endsection

@push('script')
  @include('order.script')
@endpush