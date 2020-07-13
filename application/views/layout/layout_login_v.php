<!DOCTYPE html>
<html lang="ko">
<?php $this->load->view('/include/head_v.php', $option); ?>
<body>
    <div class="App" id="App">
    <!-- 본문 -->
    <div class="Container FullPage">
        <div class="Container__main">
            <?php $this->load->view($page, $option); ?>
            <?php $this->load->view($footer, $option); ?>
        </div>
    </div>
    <!-- //본문 -->
    </div>
</body>
<?php $this->load->view('/include/tail_v.php'); ?>
</html>