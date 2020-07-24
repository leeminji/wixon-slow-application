<ul class="InputList isButton clearfix">
    <?php 
    foreach ( $detail_list as $ls ){ 
    $num = $ls->vd_num; 
    $text = $ls->vd_name;  
    ?>
    <li class="InputList__item">
        <input type="hidden" name="vd_idx[]" value="<?php echo $ls->vd_idx; ?>" />
        <input type="hidden" name="vd_name[]" value="<?php echo $text; ?>" />
        <div class="InputList__item__group">
            <div class="InputList__title"><?php echo $num; ?></div>
            <div class="InputList__data">
                <?php echo $text; ?>
            </div>
            <div class="InputList__button">
                <a href="javascript:;" class="Button Button__basic">선택</a>
            </div>
        </div>
    </li>
    <?php } ?>
</ul>
