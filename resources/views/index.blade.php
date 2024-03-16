@extends('layouts.public')

@section('title', 'Home')

@section('content')
<section class="container-fluid my-5 p-lg-5 p-3 body-container bg-it-quaternary">
</section>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ mix('views/index/index.css') }}">
<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}">
<style type="text/css" nonce="{{ csp_nonce() }}">:root { --carousel-arrow: url('{{ asset("images/settings/carousel/arrow.png") }}'); }</style>
@endsection

@section('scripts')
@endsection
