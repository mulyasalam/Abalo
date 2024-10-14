@extends('welcome')

@section('tile', 'Articles')


@section('content')

    <style>
        .item-row {
            border-bottom: #2d3748 dashed 3px;
            background-color: darkolivegreen;
        }

        .item-cell {
            border: 1px solid #2d3748;
            padding: 0.5rem 1rem; /* equivalent to px-2 py-1 */
        }
    </style>

    <div style="background-color: #1a202c; border-bottom: #6b7280 solid 3px; font-weight: bolder; border-bottom: #6b7280 solid 2px; color: #4b5563;">
        <h1 style="font-weight: bolder; border-bottom: #6b7280 solid 2px; background-color: #ffffff;">My Basket</h1>
        <div id="myBasket" style="display: flex; color: #4b5563;">

        </div>
    </div>

    <div style="display: flex; justify-content: center; align-items: center; margin-top: 10px;">
        <form METHOD="get" action="{{ url('/articles') }}">
            <label for="search">Search: </label>
            <input type="text" class="bg-zinc-400" id="search" name="search" style="margin-left: 5px; color:black; background-color: lightgray "{{ request('search') }}">
            <input type="submit" value="Search">
        </form>

        @if(request()->session()->get('abalo_user') == 'visitor')
            <a href="{{ url('/newarticle') }}" style="margin-left: auto;">Create new article</a>
        @endif


    </div>
    <br>
    <div class="">
        <table class="table-auto text-xs " style="width: 100%">
            <thead>
            <tr style="border-bottom: #2d3748 solid 3px;">
                <th class="px-2 py-2 dark:text-da">Article</th>
                <th class="px-2 py-2 dark:text-white">Description</th>
                <th class="px-2 py-2 dark:text-white">Price</th>
                <th class="px-2 py-2 dark:text-white">Images</th>
                <th class="px-2 py-2 dark:text-white">Created at</th>
                <th class="px-2 py-2 dark:text-white">Add to Basket</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($articles as $article)
                <tr class="item-row dark:bg-neutral-800" style="border-bottom: #2d3748 dashed 3px;" id="item">
                    <td class="item-cell dark:text-white card" >{{ $article->ab_name }}</td>
                    <td class="item-cell">{{ $article->ab_description }}</td>
                    <td class="item-cell">{{ number_format($article->ab_price/100,2,',','.') }} €</td>
                    <td class="item-cell"><img src="{{ asset($article->getImagePath($article->id)) }}" alt="{{ $article->ab_name }}" class="w-6" style="width: 100px;"></td>
                    <td class="item-cell">{{ $article->ab_createdate }}</td>
                    <td class="item-cell item-row" style="background-color: darkolivegreen;" onclick="addProduct({{ json_encode($article, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) }})"><button style="font-size: 50px;">+</button></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/addBasket.js') }}"></script>
@endsection

