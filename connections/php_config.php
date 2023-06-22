<?php
$identifierName = "DEV";
$proyId         = "_dev_juez";

define('c_page_title','Juez Calificador');
define('c_num_reg',10);
define('id_usr','cve_admin_cer'.$proyId);
define('_BODY_STYLE_','menubar-hoverable header-fixed menubar-pin');
//SESIONES ---
define('id_rol','tram_id_rol_cer'.$proyId );
define('user', 'usuario_cer'.$proyId );
define('admin','tram_admin_cer'.$proyId );
define('rol','tram_rol_cer'.$proyId );
define('imp','tram_imp_cer'.$proyId );
define('edit','tram_edit_cer'.$proyId );
define('elim','tram_elim_cer'.$proyId );
define('nuev','tram_nuev_cer'.$proyId );
define('export','tram_exp_cer'.$proyId );
define('s_nombre','tram_nombre_cer'.$proyId );
define('s_ncompleto','tram_ncompleto_cer'.$proyId );
define('s_f_i','tram_fecha_ingreso_cer'.$proyId );
define('looked','tram_lock_session_cer'.$proyId );
define('aplicativo', 'tram_id_aplicativo_cer'.$proyId);

define('_dir_info_dev_','bd307a3ec329e10a2cff8fb87480823da114f8f4');
//END SESIONES ---

//Sesiones extras ---
define('_editar_', 's_peditar_tram_cer'.$proyId );
define('_is_view_', 's_is_v_tram_cer'.$proyId );
define('_id_estatus_', 'id_estatus_cer'.$proyId );
define('_editar_master_', 's_peditar_master_tram_'.$proyId);
define('_type_', 's_is_type_'.$proyId);
define('_menu_', 'id_menu_navega_'.$proyId);

define('id_turno', 'id_turno_'.$proyId);
define('id_juez', 'id_juez'.$proyId);
define('id_secretario', 'id_secretario'.$proyId);

//Sesiones busqueda Reportes
define('array_filtros', 'array_filtros'.$proyId );
define('descripcion_filtros', 'descripcion_filtros'.$proyId );
