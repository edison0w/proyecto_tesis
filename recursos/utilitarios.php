<?php

//Condicion Juridica
function sectionCondicionJuridica() {
    $options = "<option value=''>Seleccione una Condición</option> "
            . "<option>Legalizado</option> "
            . "<option>En trámite</option> "
            . "<option>Sin documentos</option>";
    return $options;
}

// Listar todos Socios para la vista TODOS
function tablaDatosSocios($lista) {
    $tabla = "";
    $index = 1;
    foreach ($lista as $row) {
        $tabla .= "<tr>
                <td style='text-align: center'>" . $row['CI'] . "</td>
                <td>" . $row['APELLIDO'] . "</td>
                <td class='text-center'>" .
                "<form method='POST' action='../../controlador/conReporte.php'>"
                . "<button type='button' class='btn-link' value='" . $row['CODIGO'] . "' onclick='actualizar(this.value)' title='Editar al Socio'> 
                        <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                </button>
                <button type='button' class='btn-link' value='" . $row['CODIGO'] . "' onclick='terreno(this.value)' title='Visualizar los Terrenos del Socio'> 
                        <span class='glyphicon glyphicon-globe' aria-hidden='true'></span>
                </button>
                <button type='button' class='btn-link' value='" . $row['CODIGO'] . "' data-toggle='modal' 
                    data-target='#confirmacion' onclick='confirmacion(this.value)' title='Eliminar al Socio'> 
                        <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                </button>
                
                <input type='hidden' id='txtCodSocio' name='txtCodSocio' value='" . $row['CODIGO'] . "' />
                <button type='submit' class='btn-link' id='operacion' name='operacion' value='pdfSocio' title='Generar un reporte del Socio'> 
                        <span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span>
                </button>
                </form>
                </td>
              </tr>";
        $index++;
    }
    return $tabla;
}

// Listar todos Usuarios para la vista TODOS
function tablaDatosUsuarios($lista) {
    $tabla = "";
    $index = 1;
    foreach ($lista as $row) {
        $estado = $row['estado'] == 1 ? "Activo" : "Inactivo";
        $tabla .= "<tr>
                <td>" . $row['nombres'] . "</td>
                <td>" . $row['Rol'] . "</td>
                <td>" . $estado . "</td>
                <td class='text-center'>" .
                "<button type='button' class='btn-link' value='" . $row['id'] . "' onclick='actualizar(this.value)'> 
                        <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                </button>
                <button type='button' class='btn-link' value='" . $row['id'] . "' data-toggle='modal' 
                    data-target='#confirmacion' onclick='confirmacion(this.value)'> 
                        <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                </button>
                </td>
              </tr>";
        $index++;
    }
    return $tabla;
}

//TABLA DATOS TERRENOS SIN <td>" . $row['AREAN'] . "</td>
function tablaDatosTerrenos($lista) {
    $tabla = "";
    $index = 1;
    foreach ($lista as $row) {
        $tabla .= "<tr>
                <td>" . $row['NUM_TERRENO'] . "</td>
                <td>" . $row['AREA'] . "</td>
                <td>" . $row['AREAS'] . "</td>
                
                <td class='text-center'>" .
                "<button type='button' class='btn-link' value='" . $row['NUM_TERRENO'] . "' onclick='actualizar(this.value)' title='Editar terreno'> 
                        <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                </button>
                <button type='button' class='btn-link' value='" . $row['NUM_TERRENO'] . "' onclick='cultivos(this.value)' title='Visualizar los cultivos del terreno'> 
                        <span class='glyphicon glyphicon-leaf' aria-hidden='true'></span>
                </button>
                <button type='button' class='btn-link' value='" . $row['NUM_TERRENO'] . "' data-toggle='modal' 
                    data-target='#confirmacion' onclick='confirmacion(this.value)' title='Eliminar al terreno'> 
                        <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                </button>
                </td>
              </tr>";
        $index++;
    }
    return $tabla;
}

//TABLA DATOS TERRENOS SOCIO
function tablaDatosTerrenosSocio($lista) {
    $tabla = "";
    $index = 1;
    foreach ($lista as $row) {
        $tabla .= "<tr>
                <td>" . $row['NUM_TERRENO'] . "</td>
                <td>" . $row['AREA'] . "</td>
                <td>" . $row['AREAS'] . "</td>
                <td>" . $row['AREAN'] . "</td>
                <td class='text-center'>" .
                "<button type='button' class='btn-link' value='" . $row['NUM_TERRENO'] . "' onclick='cultivos(this.value)'> 
                        <span class='glyphicon glyphicon-leaf' aria-hidden='true'></span>
                </button>
                </td>
              </tr>";
        $index++;
    }
    return $tabla;
}

//TABLA DATOS TERRENOS
function tablaDatosTerrenoAsignarCultivos($lista) {
    $tabla = "";
    $index = 1;
    $tp = "";
    foreach ($lista as $row) {
        switch ($row['TIPO_RIEGO']) {
            case "A": $tp = "Aspersión";
                break;
            case "G": $tp = "Goteo";
                break;
            case "Gr": $tp = "Gravedad";
                break;
            case "NA": $tp = "Otro";
                break;
        }
        $tabla .= "<tr>
                <td>" . $row['NOMBRE'] . "</td>
                <td>" . $row['PORCENTAJE'] . "</td>
                <td style='text-align: center'>" . $row['FECHA_ACTUALIZACION'] . "</td>
                <td>" . $tp . "</td>
                <td class='text-center'>" .
                "<button type='button' class='btn-link' value='" . $row['NUMERO'] . "' onclick='actualizar(this.value)' title='Editar cultivo'> 
                        <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                </button>
                <button type='button' class='btn-link' value='" . $row['NUMERO'] . "' data-toggle='modal' 
                    data-target='#confirmacion' onclick='confirmacion(this.value)' title='Eliminar cultivo'> 
                        <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                </button>
                </td>
              </tr>";
        $index++;
    }
    return $tabla;
}

//TABLA DATOS TERRENOS MIS CULTIVOS
function tablaDatosTerrenoAsignarCultivos2($lista) {
    $tabla = "";
    $index = 1;
    foreach ($lista as $row) {
        $tabla .= "<tr>
                <td>" . $row['NOMBRE'] . "</td>
                <td>" . $row['PORCENTAJE'] . "</td>
                <td>" . $row['AREA'] . "</td>
                <td>" . $row['TIPO_RIEGO'] . "</td>
                
              </tr>";
        $index++;
    }
    return $tabla;
}

// Listar todos Socios para la vista BUSCAR
function tablaDatosBuscar($lista) {
    $tabla = "<optgroup label='Cédula, Nombres'><option data-hidden='true' value='0'></option>";
    foreach ($lista as $row) {
        $tabla .= "<option value='" . $row['CODIGO'] . "' data-subtext='" . $row['APELLIDO'] . "'>" . $row['CI'] . "</option>";
    }
    $tabla .= "<optgroup label='Cédula, Nombres'>";
    return $tabla;
}

// Listar todos Ususario para la vista BUSCAR
function tablaDatosBuscarUsuario($lista) {
    $tabla = "<optgroup label='Nombres, usuario, perfil'><option data-hidden='true' value='0'></option>";
    foreach ($lista as $row) {
        $tabla .= "<option value='" . $row['id'] . "' data-subtext='" . $row['username'] . ", " . $row['Rol'] . "'>" . $row['nombres'] . "</option>";
    }
    $tabla .= "<optgroup label='Nombres, usuario, perfil'>";
    return $tabla;
}

// Listar todos Socios para la vista BUSCAR
function tablaDatosBuscarTerreno($lista) {
    $tabla = "<optgroup label='Terreno, Cédula, Nombres'><option data-hidden='true' value='0'></option>";
    foreach ($lista as $row) {
        $tabla .= "<option value='" . $row['NUM_TERRENO'] . "' data-subtext='" . $row['CI'] . ", " . $row['APELLIDO'] . "'>" . $row['NUM_TERRENO'] . "</option>";
    }
    $tabla .= "<optgroup label='Cédula, Nombres'>";
    return $tabla;
}

// Listar todas las Juntas
function optionsJunta($lista) {
    $tabla = "";
    $index = 1;
    $tabla .= "<option value='-1'>"
            . "TODOS" .
            "</option>";
    foreach ($lista as $row) {
        $tabla .= "<option value='" . $row['COD_JUNTA'] . "'>"
                . $row['SECTOR_NOMBRE'] .
                "</option>";
        $index++;
    }
    return $tabla;
}

// Listar todas las Juntas
function optionsJuntaSinTodos($lista) {
    $tabla = "";
    $index = 1;
    $tabla .= "<option value=''>"
            . "Seleccione una Junta" .
            "</option>";
    foreach ($lista as $row) {
        $tabla .= "<option value='" . $row['COD_JUNTA'] . "'>"
                . $row['SECTOR_NOMBRE'] .
                "</option>";
        $index++;
    }
    return $tabla;
}

// Listar todas los Cultivos
function optionsCultivos($lista) {
    $tabla = "";
    $index = 1;
    $tabla .= "<option value=''>"
            . "Seleccione un Cultivo" .
            "</option>";
    foreach ($lista as $row) {
        $tabla .= "<option value='" . $row['COD_CULT'] . "'>"
                . $row['NOMBRE'] .
                "</option>";
        $index++;
    }
    return $tabla;
}

// Listar todas los Cultivos
function optionsRol($lista) {
    $tabla = "";
    $index = 1;
    foreach ($lista as $row) {
        $tabla .= "<option value='" . $row['id_rol'] . "'>"
                . $row['Rol'] .
                "</option>";
        $index++;
    }
    return $tabla;
}

// Listar todas las Valvulas
function optionsValvula($lista) {
    $tabla = "";
    $index = 1;
    $tabla .= "<option value=''>"
            . "Seleccione una Valvula" .
            "</option>";
    foreach ($lista as $row) {
        $tabla .= "<option value='" . $row['COD_VALVULA'] . "'>"
                . $row['DESC_VALVULA'] .
                "</option>";
        $index++;
    }
    return $tabla;
}

// Listar todos los modulos
function optionsModulo($lista) {
    $tabla = "";
    $index = 1;
    $tabla .= "<option value=''>"
            . "Seleccione un Módulo" .
            "</option>";
    foreach ($lista as $row) {
        $tabla .= "<option value='" . $row['COD_MODULO'] . "'>"
                . $row['DESC_MODULO'] .
                "</option>";
        $index++;
    }
    return $tabla;
}
