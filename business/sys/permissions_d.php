<?php //Este archivo se incluye en caso de el usuario no tenga el permiso de insertar / editar algun ventanilla.. ?>
<section class="content-header">
    <h1>
        Sin permisos para acceder a esta página
    </h1>
</section>
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"> Acceso</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> No se puede acceder a esta página</h3>
            <p>
                Este usuario no tiene permisos para acceder a esta página, o la información solicitada es incorrecta puedes regresar a <a href='<?php echo $raiz?>/business/'>Inicio</a>
                o contacta al administrador de sistema
            </p>
        </div><!-- /.error-content -->
    </div><!-- /.error-page -->

</section><!-- /.content -->
