<nav class="Sidebar" id="MainMenu">
    <div class="pt20"></div>
    <?php $menu_type = $this->menu_m->get_type('1');
    if($menu_type->mt_is_view =='Y'){ ?>    
    <div class="Sidebar__main">
        <h1 class="Sidebar__title">MENU</h1>
        <?php echo $normal_menu; ?>
    </div>
    <?php } ?>
    <?php $menu_type = $this->menu_m->get_type('2');
    if($menu_type->mt_is_view =='Y'){ ?>
    <div class="Sidebar__etc">
        <h1 class="Sidebar__title">MANAGER</h1>
        <?php echo $manage_menu; ?>
    </div>    
    <?php } ?>
    <div class="Sidebar__etc">
        <h1 class="Sidebar__title">SETTING</h1>
        <?php echo $setting_menu; ?>
    </div>
</nav>