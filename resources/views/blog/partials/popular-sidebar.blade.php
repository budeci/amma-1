<div class="articles">
    @foreach($posts as $item)
        <div class="article">
            <div class="wrapp_img">
                <a href="{{ route('view_post', ['slug' => $item->slug]) }}">
                    <img src="{{ $item->present()->cover(null, '/assets/images/img4.jpg') }}" width="248" height="157">
                </a>
            </div>
            <h6 class="title">{{ $item->present()->renderTitle() }}</h6>
            <div class="text">
                {!! $item->present()->renderShortDescription() !!}
            </div>
        </div>
    @endforeach
</div>