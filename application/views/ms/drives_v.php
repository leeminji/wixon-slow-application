
<div class="Drive">
    <?php if($back_link != null){ ?>
    <div class="Drive__top">
        <div class="Drive__back">
            <a href="<?php echo $back_link ?>">뒤로</a>
        </div>
        <h1 class="Drive__title">
            <span class="title">111</span>
        </h1>
    </div>
    <?php } ?>
    <form action="/MsOneDrive/upload" method="get" id="frm" name="frm">
    <input type="hidden" name="return_url" value="<?php echo current_url()."?". $_SERVER['QUERY_STRING']; ?>" />
    <input type="hidden" id="path" name="path" value="<?php echo $this->input->get('path') ?>" />
    <ul class="Drive__list">
    <?php foreach($drive_list as $item){ ?>
        <li class="Drive__item">
            <?php if($item['type']=='folder'){ ?>
            <div class="radio"><input type="radio" name="item_id" value="<?php echo $item['id'] ?>"></div>
            <?php } ?>
            <a class="link" href="<?php echo $item['link'] ?>">
                <span class="icon icon_<?php echo $item['type'] ?>"></span>
                <span class="name"><?php echo $item['name'] ?></span>
            </a>
        </li>
    <?php } ?>
    </ul>
    <div class="Drive__bottom">
        <div class="Button__group right">
            <input type="text" name="filename" placeholder="파일이름" />
            <Button type="submit" class="Button Button__basic"><span>업로드</span></Button>
        </div>
    </div>
    </form>
</div>

<?php //var_dump($drive_list) ?>