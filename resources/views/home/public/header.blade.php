<!--头 -->
<header>
    <article>
        <div class="mt-logo">
            <!--顶部导航条 -->
           @include('home.public.amContainer')
            <!--悬浮搜索框-->

            <div class="nav white">
                <div class="logoBig">
                    <li><a href="/home/index"><img src="/images/logobig.png"/></a></li>
                </div>

                <div class="search-bar pr">
                    <a name="index_none_header_sysc" href="#"></a>
                    <form>
                        <input id="searchInput" name="index_none_header_sysc" type="text" placeholder="搜索"
                               autocomplete="off">
                        <input id="ai-topsearch" class="submit am-btn" value="搜索" index="1" type="submit">
                    </form>
                </div>
            </div>

            <div class="clear"></div>
        </div>
        </div>
    </article>
</header>