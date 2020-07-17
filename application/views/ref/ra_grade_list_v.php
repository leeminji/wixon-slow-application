<ul class="InputList isButton clearfix">
    <?php 
    foreach ( $grade1_list as $ls ){ 
    $num = substr($ls->rg_title, 0, 5);
    $text = substr($ls->rg_title,5, strlen($ls->rg_title));  
    ?>
    <li class="InputList__item">
        <input type="hidden" name="rg_idx[]" value="<?php echo $ls->rg_idx; ?>" />
        <input type="hidden" name="rg_title[]" value="<?php echo $text; ?>" />
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
