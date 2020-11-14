<div class="product-box box {{ $campaign->isActive() ? 'box-success' : 'box-warning' }}">
    <a href="{{ action('BackendController@getCampaignDetail', $campaign->id) }}">
        <div class="product-img">
            <img src="{{ action('CampaignController@getFile', [$campaign->id, $campaign->frontCover('image_front_medium')]) }}">
        </div>
    </a>
    <div class="product-detail">
        <div class="product-name text-center">
            {{ $campaign->title }}
        </div>
        <p class="author text-center">
            <small>
                <i class="fa fa-user"></i>
                {{ $campaign->user->full_name }}
            </small>
        </p>
        <div class="row">
            <div class="col-xs-8">
                @if($campaign->status->name == 'ban')
                    <span class="label label-danger">
                        <i class="fa fa-ban"></i>
                    </span>
                    &nbsp;
                @endif

                @if($campaign->status->name == 'active')
                    <span class="label label-success">
                        <i class="fa fa-check"></i>
                    </span>
                    &nbsp;
                @endif
                @if($campaign->is_recommended)
                    <span class="label label-primary">
                        <i class="fa fa-thumbs-up"></i>
                    </span>
                    &nbsp;
                @endif
                @if($campaign->is_hot)
                    <span class="label label-primary">
                        <i class="fa fa-star"></i>
                    </span>
                    &nbsp;
                @endif

            </div>
            <div class="col-xs-4 text-right">
                <div class="dropdown column">
                    <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i
                                class="fa fa-gear"></i>
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ url($campaign->url) }}.html" class="">
                                <i class="fa fa-search">
                                </i> หน้าแสดง
                            </a>
                        </li>
                        {{--<li>--}}
                            {{--<a href="{{ action('BackendController@getSetApprove', $campaign->id) }}">--}}
                                {{--<i class="fa {{ $campaign->is_active ? 'fa-times' : 'fa-check' }}"></i> {{ $campaign->is_active ? 'Not Approve' : 'Approve' }}--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        <li>
                            <a href="{{ action('BackendController@getSetRecommended', $campaign->id) }}" class="">
                                <i class="fa {{ $campaign->is_recommended ? 'fa-thumbs-up' : 'fa-thumbs-o-up' }}">
                                </i> {{ $campaign->is_recommended ? 'Remove New' : 'Set New' }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ action('BackendController@getSetHot', $campaign->id) }}" class="">
                                <i class="fa {{ $campaign->is_hot ? 'fa-star' : 'fa-star-o' }}">
                                </i> {{ $campaign->is_hot ? 'Remove Hot' : 'Set Hot' }}
                            </a>
                        </li>
                        <li>
                            @if($campaign->status->name == 'ban' || $campaign->status->name == 'check')
                                <a class="" href='{{ action('BackendController@getActivateCampaign', $campaign->id) }}'><i
                                            class="fa fa-check"></i> อนุมัติ</a>
                            @else
                                <a class="" data-toggle="modal" href='#modal-ban-{{ $campaign->id }}'><i
                                            class="fa fa-ban"></i> ไม่อนุมัติ</a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 text-center">
                <small>{{ $campaign->status->detail }}</small>
            </div>
        </div>


        <div class="modal fade" id="modal-ban-{{ $campaign->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">เหตุผลในการระงับ</h4>
                    </div>
                    <form action="{{ action('BackendController@postBanCampaign', $campaign->id) }}" method="post">
                        {!! csrf_field() !!}
                        <div class="modal-body">
                        <textarea name="remark" id="remark" cols="30" rows="10"
                                  class="form-control"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">ยืนยัน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>