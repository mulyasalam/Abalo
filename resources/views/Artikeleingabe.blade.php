@extends('layouts.layout')

@section('title', 'Add NewArticle Page')

@section('content')
    @vite('resources/js/newarticle.vue')
@vite('resources/js/app.js')
    <div id="app">
        <!-- Content specific to the article page -->
        <newarticle></newarticle>
    </div>

@endsection


