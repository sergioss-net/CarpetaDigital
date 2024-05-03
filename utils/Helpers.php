<?php

// Función getPermisos que recibe el número de permiso como argumento
function getPermisos($numeroPermiso,$conn_bd) {
    
    $idrol = $_SESSION['userData']['id_rol'];
    $sql = "SELECT p.id_rol, p.id_modulo,m.Nombre as Modulo, p.r, p.w, p.u,p.d FROM Permisos p INNER JOIN Modulos m ON p.id_modulo = m.id_modulo WHERE p.id_rol = :id_rol";
    $permisos = $conn_bd->prepare($sql);
    $permisos->bindParam(':id_rol',$idrol);
    $permisos->execute();
    $result= $permisos-> fetchAll(PDO::FETCH_ASSOC);  
    $arrPermisos = array();
              for ($i=0; $i < count($result); $i++) { 
                  $arrPermisos[$result[$i]['id_modulo']] = $result[$i];
              }
    
    $permisos = '';
    $permisosMod = '';
    if(count($arrPermisos) > 0 ){
        $permisos = $arrPermisos;
        $permisosMod = isset($arrPermisos[$numeroPermiso]) ? $arrPermisos[$numeroPermiso] : "";
    }
    $_SESSION['permisos'] = $permisos;
    $_SESSION['permisosMod'] = $permisosMod;
    
  }
  
?>