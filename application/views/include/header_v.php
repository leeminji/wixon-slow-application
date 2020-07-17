<header class="Header">
    <div class="Header__inner">
        <div class="Header__logo"><a href="/dashboard/9">Slow</a></div>
        <div class="Header__info"><span><?php echo $this->user_info->mg_name ?></span></div>
        <nav class="Header__nav">
            <ul class="clear Navi__list">
                <li class="Navi__item"><span><?php echo $this->user_info->mb_name ?> [관리자] 접속</span></li>
                <li class="Navi__item"><a href="/auth/logout">logout</a></li>
            </ul>
        </nav>
    </div>
</header>