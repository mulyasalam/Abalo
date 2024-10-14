@extends('layouts.layout')

@section('title', 'Article Page')

@section('content')
    @vite('resources/js/echo.js')
    @vite('resources/css/app.css')




    <br>
    <div id="app">
        <navigation></navigation>
        <navigator-share
            v-bind:on-error="onError"
            v-bind:on-success="onSuccess"
            v-bind:url="url"
            v-bind:title="title"
            text="This is our new article!"
        ></navigator-share>
        <articlesearch :show-impressum="showImpressum"></articlesearch>
        <impressum-component @toggle-impressum="toggleImpressum"></impressum-component>
    </div>


@endsection

