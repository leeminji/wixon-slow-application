
<div class="Modal__inner">
    <div class="Modal__top">
        <div class="Modal__title"><?php echo $option['title']; ?></div>
        <a href="javascript:uiModal.close();" class="Modal__close">닫기</a>
    </div>
    <div class="Modal__content">
        <?php $this->load->view($page, $option); ?>
    </div>
    <div class="Modal__bottom">

    </div>
</div>
<div class="Modal__blind"></div>
