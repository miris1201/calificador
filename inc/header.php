<header id="header">
    <div class="headerbar">
        <div class="headerbar-left">
            <ul class="header-nav header-nav-options">
                <li class="header-nav-brand" >
                    <div class="brand-holder">
                        <a href="<?php echo $raiz?>">
                            <img src="dist/assets/img/logo.png?v=1">
                        </a>
                        <a href="<?php echo $raiz?>business/" class="margin-logo-op">
                        </a>
                    </div>
                </li>
                <li>
                    <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                        <i class="glyphicon glyphicon-menu-hamburger"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="headerbar-right">
            <ul class="header-nav header-nav-profile">
                <li class="dropdown">                    
                    <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                        <span class="profile-info">
                            <?php echo $_SESSION[s_nombre]?>
                            <small><?php echo $_SESSION[rol]?></small>
                        </span>
                    </a>
                    <ul class="dropdown-menu animation-dock">
                        <li class="dropdown-header">Configuración</li>
                        <li><a href="<?php echo $raiz?>?controller=sys&action=account">Mi cuenta</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $raiz?>business/sys/logout.php"><i class="glyphicon glyphicon-off text-danger"></i> Salir del sistema</a></li>
                    </ul>
                </li>                
            </ul>
        </div>
    </div>
</header>