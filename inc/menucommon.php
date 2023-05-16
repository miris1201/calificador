<div id="menubar" class="menubar-inverse  animate">
    <div class="menubar-fixed-panel">
        <div>
            <a 
                class="btn btn-icon-toggle btn-default menubar-toggle" 
                data-toggle="menubar" 
                href="javascript:void(0);" 
                accesskey="m">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <div class="expanded">
            <a href="">
            </a>
        </div>
    </div>
    <div class="menubar-scroll-panel">

    <!-- BEGIN MAIN MENU -->
    <ul id="main-menu" class="gui-controls">
        <li>
            <a 
                href="<?php echo $raiz?>?controller=business&action=show" 
                <?php if($checkMenu == $raiz."?controller=business"){ echo "class='active'";}?> >
                <div class="gui-icon"><i class="glyphicon glyphicon-home"></i></div>
                <span class="title">Inicio</span>
            </a>
        </li>
        <?php
        $result = $cInicial->menuParents($_SESSION[id_usr]);

        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
        $idpadre = $row->id_menu;

        $result2 = $cInicial->menuChild($idpadre, $_SESSION[id_usr]);
        $totalRows_row2 = $result2->rowCount();

        $ipadre = "";
        $padreActivo ="";
        if ($totalRows_row2 > 0) {
            $ipadre = "gui-folder ";
            $padreActivo = "";
            $menu = "<ul>";
            while ($row2 = $result2->fetch(PDO::FETCH_OBJ)){
                if($sys_id_men == $row2->id_menu){
                    $activo = "active expanded";
                    $padreActivo = "active expanded";
                }else{
                    $activo = "";
                }                                 

                $menu.="<li class='".$activo."'>
                            <a href='".$raiz.$row2->link."' >
                                <span class='title'>".$row2->texto." </span>
                                
                            </a>
                        </li>";
            }
            $menu.= "</ul>";
        }
        ?>
            <li class="<?php echo $ipadre.$padreActivo ?>">
                <a href="javascript:void(0);">
                    <div class="gui-icon"><i class="<?php echo $row->class ;?>"></i></div>
                    <span class="title"><?php echo $row->texto ;?></span>
                </a>
                <?php
                if($totalRows_row2!="0") {
                    echo $menu;
                }
                ?>
            </li>
        <?php
        }
        ?>
    </ul>
    <div class="menubar-foot-panel">
        <small class="no-linebreak hidden-folded">
            <span class="opacity-75">Copyright &copy; <?php echo date("Y");?></span> <b><?php echo c_page_title?></b>
        </small>
    </div>
</div>
</div>