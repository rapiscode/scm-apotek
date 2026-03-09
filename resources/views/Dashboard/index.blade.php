@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Dashboard')
@section('page_title', 'Welcome to APOTEK SAYA')
@section('page_subtitle', 'Hi, ' . (auth()->user()->name ?? 'User') . ', Welcome back!')

@section('content')
@endsection