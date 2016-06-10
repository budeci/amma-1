<div class="right top-bar-langs">
    {{--<!-- todo: find a way to use URL::lang_to($languages['current']->slug) -->--}}
    <a href='/{{ $languages['current']->slug }}' data-activates='dropdown_top-bar-langs'
       class="dropdown_top_bar"><i class="icon-{{$languages['current']->slug}}"></i>
        {{$languages['current']->title}}&nbsp;<i class="icon-la-down"></i>
    </a>
    <ul id='dropdown_top-bar-langs' class='dropdown-content'>
        @foreach($languages['other'] as $lang)
            <li>
                <a href="/{{ $lang->slug }}">
                    <i class="icon-{{$lang->slug}}"></i>&nbsp;{{$lang->title}}
                </a>
            </li>
        @endforeach
    </ul>
</div>