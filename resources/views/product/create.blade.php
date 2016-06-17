@extends('layout')

@section('content')
    <section class="">
        <div class="container">
            <div class="row">
                @include('partials.dashboard.nav-bar')
                <div class="col l9 m7 s12">
                    <form method="post" action="{{ route('post_create_product', ['vendor' => $vendor->slug]) }}"
                          class="form styled2 row validate-it" enctype="multipart/form-data">
                        @include('product.partials.form')
                        {!! csrf_field() !!}
                        <div class="col l12">
                            <button type="submit" class="btn btn_base btn_submit">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection