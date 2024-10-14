@extends('layouts.layout')

@section('title', 'Article Page')

@section('content')


    @vite('resources/js/echo.js')




    <br>
    <div id="app">
        <navigation></navigation>
        <DarkMode></DarkMode>
        <navigator-share
            v-bind:on-error="onError"
            v-bind:on-success="onSuccess"
            v-bind:url="url"
            v-bind:title="title"
            text="Hello World"
        ></navigator-share>
        <h1 style="font-weight: bolder;"> My Basket</h1>
        <div id="myBasket" class="flex dark:text-gray-800">
        </div>
        <articlesearch :show-impressum="showImpressum"></articlesearch>
        <impressum-component></impressum-component>
    </div>


@endsection

