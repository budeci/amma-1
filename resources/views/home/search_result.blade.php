@extends('layout')

@section('content')
    <section class="history_buy">
        <div class="container">
            <div class="row">
                @include('categories.partials.filters')

                @if($count = count($products))
                    <div class="col l9 m7 s12">

                    @include('categories.partials.sort_form')

                    @if($count <= 6)
                        <div class="row elements bordered pd10 styled1 no-row-margin divide-top">
                            @foreach($products as $item)
                                <div class="col l4 m6 s12">
                                    @include('partials.products.item-block')
                                </div>
                            @endforeach
                        </div>

                        @include('partials.banners.wide')
                    @else
                        <?php
                        list($before_banner, $after_banner) = $products->chunk(6);
                        ?>
                        <div class="row elements bordered pd10 styled1 no-row-margin divide-top">
                            @foreach($before_banner as $item)
                                <div class="col l4 m6 s12">
                                    @include('partials.products.item-block')
                                </div>
                            @endforeach
                        </div>

                        @include('partials.banners.wide')

                        <div class="row elements bordered pd10 styled1 no-row-margin divide-top">
                            @foreach($after_banner as $item)
                                <div class="col l4 m6 s12">
                                    @include('partials.products.item-block')
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div><!--right block-->
                @else
                    <p>Search result: No products find.</p>
                @endif
            </div>
        </div>
    </section>
@endsection