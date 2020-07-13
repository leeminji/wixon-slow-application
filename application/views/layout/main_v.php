<!DOCTYPE html>
<html lang="ko">
<?php $this->load->view('/include/head_v.php', $option); ?>
<body>
    <div class="App" id="App">
    <?php $this->load->view($header, $option); ?>
    <!-- 본문 -->
    <div class="Container" id="Container">
        <div class="Container__sidebar">    
            <?php $this->load->view($sidebar, $option); ?>
        </div>
        <div class="Container__main" id="ContainerMain">
            <?php $this->load->view($page, $option); ?>
            <?php $this->load->view($footer, $option); ?>
        </div>
    </div>
    <!-- //본문 -->
    </div>
</body>
<?php $this->load->view('/include/tail_v.php'); ?>
</html>