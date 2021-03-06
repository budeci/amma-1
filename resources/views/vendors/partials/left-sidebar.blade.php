<div class="col l4 m5 s12">
    <div class="bordered divide-top">
        <div class="block_title">{!! $meta->getMeta('left_sidebar_aboutvendor') !!}</div>
        <div class="person_card">
            <div class="display_flex border_bottom">
                <div class="wrapp_img">
                    <img src="{{ $item->present()->cover() }}">
                </div>
                <div class="content">
                    <h4>{{ $item->present()->renderTitle()}}</h4>
                    <div class="label" style=''>
                        <div class="user-rating">
                            <span class="stars"><span class="bg" style="width: {{ $item->present()->renderPozitiveVotes() }}%"></span></span>
                            <span>{{ $item->present()->renderPozitiveVotes() }}%</span>
                            <span class="c-gray"> ({{ $item->present()->getLikesNumber() }} {!! $meta->getMeta('left_sidebar_votes_count') !!})</span>
                        </div>
                    </div>
                </div>
            </div>
            @if($item->user->id == \Auth::id())
                <div class="buttons row">
                    <div class="col s12 padd_l_half">
                        <a href="{{ route('add_lot', [ $item->slug ]) }}"
                           class="btn_ btn_white waves-effect waves-teal f_small right full_width">{!! $meta->getMeta('left_sidebar_addlot') !!}</a>
                    </div>
                </div>

                <div class="buttons row">
                    <div class="col s12 padd_l_half">
                        <a href="{{ route('edit_vendor', ['vendor' => $item->slug]) }}"
                           class="btn_ btn_white waves-effect waves-teal f_small right full_width">{!! $meta->getMeta('left_sidebar_editvendor') !!}</a>
                    </div>
                </div>
            @else
                <div class="buttons row">
                    <div class="col s12 padd_l_half">
                        <a href="#"
                           class="btn_ btn_white waves-effect waves-teal f_small right full_width">{!! $meta->getMeta('left_sidebar_contact') !!}</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>