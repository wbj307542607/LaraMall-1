@extends('home.layouts.master')

@section('title')
    商品详情页
@stop

@section('externalCss')
    <link href="/basic/css/demo.css" rel="stylesheet" type="text/css"/>
    <link type="text/css" href="/css/optstyle.css" rel="stylesheet"/>
    <link type="text/css" href="/css/style.css" rel="stylesheet"/>
@stop

@section('customCss')
    <link type="text/css" href="/css/custom/goodsDetail.css" rel="stylesheet"/>
@stop

@section('coreJs')
    <script type="text/javascript" src="/basic/js/jquery-1.7.min.js"></script>
    <script type="text/javascript" src="/basic/js/quick_links.js"></script>
    <script src="/layer/layer.js"></script>
@stop

@section('externalJs')
    <script type="text/javascript" src="/AmazeUI-2.4.2/assets/js/amazeui.js"></script>
    <script type="text/javascript" src="/js/jquery.imagezoom.min.js"></script>
    <script type="text/javascript" src="/js/jquery.flexslider.js"></script>
    <script>
        var csrf_token = '{{ csrf_token() }}';
        @if($data['activity'] && $data['activity']->cargoActivity)
            var intDiff = parseInt('{{ $data['activity']->length * 60 - (time() - $data['activity']->start_timestamp) }}');
        @endif
    </script>
    <script type="text/javascript" src="/js/list.js"></script>
@stop

@section('header')
    @include('home.public.amContainer')
@stop

@section('nav')
    @include('home.public.nav')
@stop

@section('content')
    @inject('DetailPresenter', 'App\Presenters\HomeGoodsDetailPresenter')
    <b class="line"></b>
    <div class="listMain">

        <!--分类-->
        <div class="nav-table">
            <div class="long-title"><span class="all-goods">全部分类</span></div>
            <div class="nav-cont">
                <ul>
                    <li class="index"><a href="/home/index">首页</a></li>
                    <li class="qc"><a href="#">闪购</a></li>
                    <li class="qc"><a href="#">限时抢</a></li>
                    <li class="qc"><a href="#">团购</a></li>
                    <li class="qc last"><a href="#">大包装</a></li>
                </ul>
                <div class="nav-extra">
                    <i class="am-icon-user-secret am-icon-md nav-user"></i><b></b>我的福利
                    <i class="am-icon-angle-right" style="padding-left: 10px;"></i>
                </div>
            </div>
        </div>
        <ol class="am-breadcrumb am-breadcrumb-slash">
            @foreach($data['tree'] as $k => $v)
                @if($k == 2)
                    <li><a href="/home/goodsList/{{ $v['id'] }}">{{ $v['name'] }}</a></li>
                @else
                    <li>{{ $v['name'] }}</li>
                @endif
            @endforeach
            <li class="am-active">{{ $data['cargo']->cargo_name }}</li>
        </ol>
        <script type="text/javascript">
            $(function () {
            });
            $(window).load(function () {
                $('.flexslider').flexslider({
                    animation: "slide",
                    start: function (slider) {
                        $('body').removeClass('loading');
                    }
                });
            });
        </script>
        <div class="scoll">
            <section class="slider">
                <div class="flexslider">
                    <ul class="slides">
                        <li>
                            <img src="/images/01.jpg" title="pic"/>
                        </li>
                        <li>
                            <img src="/images/02.jpg"/>
                        </li>
                        <li>
                            <img src="/images/03.jpg"/>
                        </li>
                    </ul>
                </div>
            </section>
        </div>

        <!--放大镜-->
        <div class="item-inform">
            <div class="clearfixLeft" id="clearcontent">
                <div class="box">
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $(".jqzoom").imagezoom();
                            $("#thumblist li a").click(function () {
                                $(this).parents("li").addClass("tb-selected").siblings().removeClass("tb-selected");
                                $(".jqzoom").attr('src', $(this).find("img").attr("mid"));
                                $(".jqzoom").attr('rel', $(this).find("img").attr("big"));
                            });
                        });
                    </script>

                    <div class="tb-booth tb-pic tb-s310">
                        <a href="{{ env('QINIU_DOMAIN') }}{{ $data['cargo']->cargo_cover }}?imageView2/1/w/800/h/800">
                            <img src="{{ env('QINIU_DOMAIN') }}{{ $data['cargo']->cargo_cover }}?imageView2/1/w/350/h/350"
                                 alt="细节展示放大镜特效"
                                 rel="{{ env('QINIU_DOMAIN') }}{{ $data['cargo']->cargo_cover }}?imageView2/1/w/800/h/800"
                                 class="jqzoom"/>
                        </a>
                    </div>

                    <ul class="tb-thumb" id="thumblist">
                        @foreach(json_decode($data['cargo']->cargo_original) as $v)
                            <li class="tb-selected">
                                <div class="tb-pic tb-s40">
                                    <a href="#">
                                        <img src="{{ env('QINIU_DOMAIN') }}{{ $v }}?imageView2/1/w/60/h/60"
                                             mid="{{ env('QINIU_DOMAIN') }}{{ $v }}?imageView2/1/w/350/h/350"
                                             big="{{ env('QINIU_DOMAIN') }}{{ $v }}?imageView2/1/w/800/h/800">
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="clear"></div>
            </div>

            <div class="clearfixRight">

                <!--规格属性-->
                <!--名称-->
                <div class="tb-detail-hd" data-cargo-id="{{ $data['cargo']->id }}">
                    <h1>
                        {{ $data['cargo']->cargo_name }}
                    </h1>
                </div>
                <div class="tb-detail-list">
                    <!--价格-->
                    <div class="tb-detail-price">
                        @if($data['activity'] && $data['activity']->cargoActivity)
                            <li class="price iteminfo_price">
                                <dt>秒杀价</dt>
                                <dd><em>¥</em><b
                                            class="sys_item_price">{{ $data['activity']->cargoActivity->promotion_price }}</b>
                                </dd>
                            </li>
                            <li class="price iteminfo_mktprice">
                                <dt>原价</dt>
                                <dd><em>¥</em><b class="sys_item_mktprice">{{ $data['cargo']->cargo_price }}</b></dd>
                            </li>
                        @else
                            <li class="price iteminfo_price">
                                <dt>价格</dt>
                                <dd><em>¥</em><b class="sys_item_price">{{ $data['cargo']->cargo_price }}</b></dd>
                            </li>
                        @endif
                        <div class="clear"></div>
                    </div>

                    {{--<!--地址-->--}}
                    {{--<dl class="iteminfo_parameter freight">--}}
                        {{--<dt>配送至</dt>--}}
                        {{--<div class="iteminfo_freprice">--}}
                            {{--<div class="am-form-content address">--}}
                                {{--<select data-am-selected>--}}
                                    {{--<option value="a">浙江省</option>--}}
                                    {{--<option value="b">湖北省</option>--}}
                                {{--</select>--}}
                                {{--<select data-am-selected>--}}
                                    {{--<option value="a">温州市</option>--}}
                                    {{--<option value="b">武汉市</option>--}}
                                {{--</select>--}}
                                {{--<select data-am-selected>--}}
                                    {{--<option value="a">瑞安区</option>--}}
                                    {{--<option value="b">洪山区</option>--}}
                                {{--</select>--}}
                            {{--</div>--}}
                            {{--<div class="pay-logis">--}}
                                {{--快递<b class="sys_item_freprice">10</b>元--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</dl>--}}
                    {{--<div class="clear"></div>--}}

                    {{--<!--销量-->--}}
                    {{--<ul class="tm-ind-panel">--}}
                        {{--<li class="tm-ind-item tm-ind-sellCount canClick">--}}
                            {{--<div class="tm-indcon"><span class="tm-label">月销量</span><span class="tm-count">1015</span>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<li class="tm-ind-item tm-ind-sumCount canClick">--}}
                            {{--<div class="tm-indcon"><span class="tm-label">累计销量</span><span class="tm-count">6015</span>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<li class="tm-ind-item tm-ind-reviewCount canClick tm-line3">--}}
                            {{--<div class="tm-indcon"><span class="tm-label">累计评价</span><span class="tm-count">640</span>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                    {{--<div class="clear"></div>--}}

                    <!--各种规格-->
                    <dl class="iteminfo_parameter sys_item_specpara">
                        <dt class="theme-login">
                        <div class="cart-title">可选规格<span class="am-icon-angle-right"></span></div>
                        </dt>
                        <dd>
                            <!--操作页面-->
                            <div class="theme-popover-mask"></div>

                            <div class="theme-popover">
                                <div class="theme-span"></div>
                                <div class="theme-poptit">
                                    <a href="javascript:;" title="关闭" class="close">×</a>
                                </div>
                                <div class="theme-popbod dform">
                                    <form class="theme-signin" name="loginform" action="" method="post">
                                        <div class="theme-signin-left">
                                            @foreach($data['goods']->labels as $label)
                                                <div class="theme-options">
                                                    <div class="cart-title">{{ $label->goods_label_name }}</div>
                                                    <ul>
                                                        @foreach($DetailPresenter->filterAttr($label->attrs, $data['goods']->attrs) as $attr)
                                                            @if($DetailPresenter->selectedAttr($label->id, $attr->id, $data['cargo'], $data['cids']) == 'selected')
                                                                <li class="sku-line selected"
                                                                    data-label="{{ $label->id }}"
                                                                    data-attr="{{ $attr->id }}">{{ $attr->goods_label_name }}
                                                                    <i></i></li>
                                                            @elseif($DetailPresenter->selectedAttr($label->id, $attr->id, $data['cargo'], $data['cids']) == 'normal')
                                                                <li class="sku-line" data-label="{{ $label->id }}"
                                                                    data-attr="{{ $attr->id }}">{{ $attr->goods_label_name }}
                                                                    <i></i></li>
                                                            @else
                                                                <li class="sku-line in-no-stock"
                                                                    data-label="{{ $label->id }}"
                                                                    data-attr="{{ $attr->id }}">{{ $attr->goods_label_name }}
                                                                    <i></i></li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                            <div class="theme-options">
                                                <div class="cart-title number">数量</div>
                                                <div>
                                                    <input id="min" class="am-btn am-btn-default" name="" type="button"
                                                           value="-"/>
                                                    <input id="text_box" name="" type="text" value="1"
                                                           style="width:30px;"/>
                                                    <input id="add" class="am-btn am-btn-default" name="" type="button"
                                                           value="+"/>
                                                    <span id="Stock" class="tb-hidden">库存<span class="stock"
                                                                                               id="cargo_num">{{ $data['cargo']->inventory }}</span>件</span>
                                                </div>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="btn-op">
                                                <div class="btn am-btn am-btn-warning">确认</div>
                                                <div class="btn close am-btn am-btn-warning">取消</div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </dd>
                    </dl>
                    <div class="clear"></div>
                    <!--活动	-->
                    @if($data['activity'] && $data['activity']->cargoActivity)
                        <div class="shopPromotion gold activity">
                            <span class="intDiff">  </span>
                            <h3>京东秒杀</h3>
                        </div>
                    @else
                        <div class="shopPromotion gold">
                            <div class="hot">
                                <dt class="tb-metatit">店铺优惠</dt>
                                <div class="gold-list">
                                    <p>购物满2件打8折，满3件7折<span>点击领券<i class="am-icon-sort-down"></i></span></p>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="coupon">
                                <dt class="tb-metatit">优惠券</dt>
                                <div class="gold-list">
                                    <ul>
                                        <li>125减5</li>
                                        <li>198减10</li>
                                        <li>298减20</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="pay">
                    <div class="pay-opt">
                        <a href="home.html"><span class="am-icon-home am-icon-fw">首页</span></a>
                        <a><span class="am-icon-heart am-icon-fw">收藏</span></a>

                    </div>
                    @if($data['activity'] && $data['activity']->cargoActivity)
                        <li>
                            @if($data['activity']->cargoActivity->number > 0)
                                <a class="am-btn am-btn-danger" id="toSnapUp" title="立即抢购" href="javascript:;"
                                   data-cargoId="{{ $data['cargo']->id }}"><i></i>立即抢购</a>
                            @else
                                <a class="am-btn am-btn-default" id="toSnapUp" title="已抢光" href="javascript:;"
                                   data-cargoId="{{ $data['cargo']->id }}"><i></i>已抢光</a>
                            @endif
                        </li>
                    @else
                        <li>
                            <div class="clearfix tb-btn tb-btn-buy theme-login">
                                <a id="LikBuy" title="点此按钮到下一步确认购买信息" href="javascript:;"
                                   data-cargoId="{{ $data['cargo']->id }}">立即购买</a>
                            </div>
                        </li>
                        <li>
                            <div class="clearfix tb-btn tb-btn-basket theme-login">
                                <a id="LikBasket" title="加入购物车" href="javascript:;"
                                   data-cargoId="{{ $data['cargo']->id }}"><i></i>加入购物车</a>
                            </div>
                        </li>
                    @endif
                </div>

            </div>

            <div class="clear"></div>

        </div>

        <!--优惠套装-->
        <div class="match">
            <div class="match-title">优惠套装</div>
            <div class="match-comment">
                <ul class="like_list">
                    <li>
                        <div class="s_picBox">
                            <a class="s_pic" href="#"><img src="/images/cp.jpg"></a>
                        </div>
                        <a class="txt" target="_blank" href="#">萨拉米 1+1小鸡腿</a>
                        <div class="info-box"><span class="info-box-price">¥ 29.90</span> <span
                                    class="info-original-price">￥ 199.00</span>
                        </div>
                    </li>
                    <li class="plus_icon"><i>+</i></li>
                    <li>
                        <div class="s_picBox">
                            <a class="s_pic" href="#"><img src="/images/cp2.jpg"></a>
                        </div>
                        <a class="txt" target="_blank" href="#">ZEK 原味海苔</a>
                        <div class="info-box"><span class="info-box-price">¥ 8.90</span> <span
                                    class="info-original-price">￥ 299.00</span>
                        </div>
                    </li>
                    <li class="plus_icon"><i>=</i></li>
                    <li class="total_price">
                        <p class="combo_price"><span class="c-title">套餐价:</span><span>￥35.00</span></p>
                        <p class="save_all">共省:<span>￥463.00</span></p> <a href="#" class="buy_now">立即购买</a></li>
                    <li class="plus_icon"><i class="am-icon-angle-right"></i></li>
                </ul>
            </div>
        </div>
        <div class="clear"></div>


        <!-- introduce-->
        <div class="introduce">
            <div class="browse">
                <div class="mc">
                    <ul>
                        <div class="mt">
                            <h2>看了又看</h2>
                        </div>

                        <li class="first">
                            <div class="p-img">
                                <a href="#"> <img class="" src="/images/browse1.jpg"> </a>
                            </div>
                            <div class="p-name"><a href="#">
                                    【三只松鼠_开口松子】零食坚果特产炒货东北红松子原味
                                </a>
                            </div>
                            <div class="p-price"><strong>￥35.90</strong></div>
                        </li>
                        <li>
                            <div class="p-img">
                                <a href="#"> <img class="" src="/images/browse1.jpg"> </a>
                            </div>
                            <div class="p-name"><a href="#">
                                    【三只松鼠_开口松子】零食坚果特产炒货东北红松子原味
                                </a>
                            </div>
                            <div class="p-price"><strong>￥35.90</strong></div>
                        </li>
                        <li>
                            <div class="p-img">
                                <a href="#"> <img class="" src="/images/browse1.jpg"> </a>
                            </div>
                            <div class="p-name"><a href="#">
                                    【三只松鼠_开口松子】零食坚果特产炒货东北红松子原味
                                </a>
                            </div>
                            <div class="p-price"><strong>￥35.90</strong></div>
                        </li>
                        <li>
                            <div class="p-img">
                                <a href="#"> <img class="" src="/images/browse1.jpg"> </a>
                            </div>
                            <div class="p-name"><a href="#">
                                    【三只松鼠_开口松子】零食坚果特产炒货东北红松子原味
                                </a>
                            </div>
                            <div class="p-price"><strong>￥35.90</strong></div>
                        </li>
                        <li>
                            <div class="p-img">
                                <a href="#"> <img class="" src="/images/browse1.jpg"> </a>
                            </div>
                            <div class="p-name"><a href="#">
                                    【三只松鼠_开口松子218g】零食坚果特产炒货东北红松子原味
                                </a>
                            </div>
                            <div class="p-price"><strong>￥35.90</strong></div>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="introduceMain">
                <div class="am-tabs" data-am-tabs>
                    <ul class="am-avg-sm-3 am-tabs-nav am-nav am-nav-tabs">
                        <li class="am-active">
                            <a href="#">

                                <span class="index-needs-dt-txt">宝贝详情</span></a>

                        </li>

                        <li>
                            <a href="#">

                                <span class="index-needs-dt-txt">全部评价</span></a>

                        </li>
                    </ul>

                    <div class="am-tabs-bd">

                        <div class="am-tab-panel am-fade am-in am-active">
                            <div class="J_Brand">

                                <div class="attr-list-hd tm-clear">
                                    <h4>产品参数：</h4></div>
                                <div class="clear"></div>
                                <ul id="J_AttrUL">
                                    <li title="">产品类型:&nbsp;烘炒类</li>
                                    <li title="">原料产地:&nbsp;巴基斯坦</li>
                                    <li title="">产地:&nbsp;湖北省武汉市</li>
                                    <li title="">配料表:&nbsp;进口松子、食用盐</li>
                                    <li title="">产品规格:&nbsp;210g</li>
                                    <li title="">保质期:&nbsp;180天</li>
                                    <li title="">产品标准号:&nbsp;GB/T 22165</li>
                                    <li title="">生产许可证编号：&nbsp;QS4201 1801 0226</li>
                                    <li title="">储存方法：&nbsp;请放置于常温、阴凉、通风、干燥处保存</li>
                                    <li title="">食用方法：&nbsp;开袋去壳即食</li>
                                </ul>
                                <div class="clear"></div>
                            </div>

                            <div class="details">
                                <div class="attr-list-hd after-market-hd">
                                    <h4>商品细节</h4>
                                </div>
                                <div class="twlistNews">
                                    {!! $data['cargo']->cargo_info !!}
                                </div>
                            </div>
                            <div class="clear"></div>

                        </div>

                        <div class="am-tab-panel am-fade">
                            <div class="clear"></div>
                            <div class="tb-r-filter-bar">
                                <ul class=" tb-taglist am-avg-sm-4">
                                    <li class="tb-taglist-li tb-taglist-li-current">
                                        <div class="comment-info" style="cursor:pointer" data-type="0">
                                            <span>全部评价</span>
                                            <span class="tb-tbcr-num">{{ $data['star']['good']+$data['star']['almost'] +$data['star']['bad'] }}</span>
                                        </div>
                                    </li>

                                    <li class="tb-taglist-li tb-taglist-li-1">
                                        <div class="comment-info" style="cursor:pointer" data-type="1">
                                            <span>好评</span>
                                            <span class="tb-tbcr-num">{{ $data['star']['good'] }}</span>
                                        </div>
                                    </li>

                                    <li class="tb-taglist-li tb-taglist-li-0">
                                        <div class="comment-info" style="cursor:pointer" data-type="2">
                                            <span>中评</span>
                                            <span class="tb-tbcr-num">{{ $data['star']['almost'] }}</span>
                                        </div>
                                    </li>

                                    <li class="tb-taglist-li tb-taglist-li--1">
                                        <div class="comment-info" style="cursor:pointer" data-type="3">
                                            <span>差评</span>
                                            <span class="tb-tbcr-num">{{ $data['star']['bad'] }}</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="clear"></div>

                            <ul class="am-comments-list am-comments-list-flip">


                            </ul>

                            <div class="clear"></div>

                            <!--分页 -->

                            <div class="clear"></div>

                            <div style="width:100%;padding:50px 0px" id="moreButton">
                                <button type="button" id="commentMore">加载更多</button>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="clear"></div>
                @include('home.public.footer')
            </div>

        </div>
    </div>

    @include('home.public.tip')

@stop
@section('customJs')
    <script src="{{ asset('/js/check.js') }}"></script>
    <script>
        // 评论内容模板
        var commentContent = '';
        // 评论内容
        var content ='';
        // 总页数
        var totalPage='';
        // 初始化当前页
        var page = 1;
        // 初始化 传输数据
        var data = {
            'page':page,
            '_token':"{{ csrf_token() }}",
            'cargo_id':$('.tb-detail-hd').attr('data-cargo-id'),
            'star':''
        };
        @if($data['activity'] && $data['activity']->cargoActivity)
        // 立即抢购
        $('#toSnapUp').on('click', function () {
            // 判断是否登录，没有登录需要先登录
            if (!'{{ Session::has('user') }}') {
                location.href = '/home/login';
            }

            @if(Session::has('user'))
                var data = {
                    cargo_id: '{{ $data["cargo"]->id }}',
                    activity_id: '{{ $data['activity']->id }}',
                    number: $('#text_box').val()
                };
            @endif

            sendAjax(data, '/home/addToShoppingCart', function (response) {
                if(response.ServerNo == 414){
                    layer.alert(response.ResultData);
                    return;
                }

                if(response.ServerNo != 200){
                    layer.alert(response.ResultData);
                    return;
                }
                location.href = '/home/shoppingCart';
            });
        });
        @endif

        // 立即购买
        $('#LikBuy').click(function () {
            // 判断是否登录，没有登录需要先登录
            if (!'{{ Session::has('user') }}') {
                location.href = '/home/login';
            }

            var data = {
                cargo_id: '{{ $data["cargo"]->id }}',
                number: $('#text_box').val()
            };

            sendAjax(data, '/home/addToShoppingCart', function (response) {
                if(response.ServerNo == 414){
                    layer.alert(response.ResultData);
                    return;
                }

                if(response.ServerNo != 200){
                    layer.alert(response.ResultData);
                    return;
                }
                location.href = '/home/shoppingCart';
            });
        });

        // 加入购物车
        $('#LikBasket').click(function () {
            // 判断是否登录，没有登录需要先登录
            if (!'{{ Session::has('user') }}') {
                location.href = '/home/login';
            }

            var data = {
                cargo_id: '{{ $data["cargo"]->id }}',
                number: $('#text_box').val()
            };

            sendAjax(data, '/home/addToShoppingCart', function (response) {
                if(response.ServerNo == 414){
                    layer.alert(response.ResultData);
                    return;
                }

                if(response.ServerNo != 200){
                    layer.alert(response.ResultData);
                    return;
                }
                var number = parseInt($('#J_MiniCartNum').html()) + parseInt(response.ResultData);
                $('#J_MiniCartNum').html(number);
                $('.cart_num').html(number);
            });
        });
        // 第一次加载数据
        $(function(){
            getComment(data);
        });
        // 加载更过获取下一页数据
        $('#commentMore').click(function(){
            layer.load(2);
            if(page >= totalPage){
                layer.closeAll();
                return layer.msg('没有更多评论了');

            }
            page =page+1;
            data.page=page;
            getComment(data);
            layer.closeAll();

        });
        // 按评价搜索
        $('.comment-info').click(function(){
            layer.load(2);
            page = 1;
            content='';
            data.star = $(this).attr('data-type');
            data.page = page;
            getComment(data);
            layer.closeAll();
        });
        // 加载数据函数
        function getComment(data){
            sendAjax(data,'/home/goodsDetails/comments',function(response){
                $('#moreButton').show();
                if(response.ServerNo ==200){
                    if(response.ResultData.data.length >= 1){
                        $.each(response.ResultData.data,function(k,v){
                            content += fillData(v);
                        });
                        $('.am-comments-list').html(content);
                        totalPage = response.ResultData.totalPage;
                    }else{
                        $('#moreButton').hide();
                        $('.am-comments-list').html('<div style="padding:50px 0px;font-size:16px;color:red">暂无评价内容</divstyle>');
                    }

                }else{
                    $('.tb-taglist').hide();
                    $('#moreButton').hide();
                    $('.am-comments-list').html('<div style="padding:50px 0px;font-size:16px;color:red">暂无评价内容</divstyle>');

                }
            });
        }
        // 组装页面模板
        function fillData(v)
        {
            var avatar = '';
            if(!v.user.avatar){
                avatar = "{{ asset('/images/hwbn40x40.jpg') }}";
            }else{
                avatar = "{{ env('QINIU_DOMAIN') }}"+v.user.avatar;
            }
            commentContent+='<li class="am-comment">';
            commentContent+='<a href="">';
            commentContent+='<img class="am-comment-avatar" src="'+avatar+'"/>';
            commentContent+='</a>';
            commentContent+='<div class="am-comment-main">';
            commentContent+='<header class="am-comment-hd">';
            commentContent+='<div class="am-comment-meta">';
            commentContent+='<a href="#link-to-user" class="am-comment-author">'+v.user.nickname+'</a>';
            commentContent+='<time datetime="">'+v.created_at+'</time>';
            commentContent+='</div>';
            commentContent+='</header>';
            commentContent+='<div class="am-comment-bd">';
            commentContent+='<div class="tb-rev-item " data-id="255776406962">';
            commentContent+='<div class="J_TbcRate_ReviewContent tb-tbcr-content ">';
            commentContent+= v.comment_info
            commentContent+='</div>';
            commentContent+='</div>';
            commentContent+='</div>';
            commentContent+='</div>';
            commentContent+='</li>';
            var tmp = commentContent;
            commentContent='';
            return tmp;
        }
    </script>
@stop
