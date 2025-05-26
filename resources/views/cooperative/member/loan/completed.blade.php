@extends('cooperative.member.master')
@section('main')

<main class="adminuiux-content has-sidebar" onclick="contentClick()">
   
    <div class="container-fluid">

        <!-- start page title -->
       

        @livewire('member-completed-loan')

    </div>
</main>
<!-- container-fluid -->
@endsection