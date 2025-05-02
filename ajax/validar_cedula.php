<?php
// validar_cedula.php - Archivo para procesar solicitudes AJAX de validación de cédula

// Incluir los archivos necesarios
require_once '../includes/conexion.php'; 
require_once '../clases/Cliente.php';

/**
 * Función para validar cédula ecuatoriana
 * @param string $cedula El número de cédula a validar
 * @return mixed true si es válida, string con mensaje de error si no es válida
 */
function validarCedula($cedula) {
    // Verificar que la cédula tenga exactamente 10 dígitos
    if (strlen($cedula) != 10) {
        return "La cédula debe tener 10 dígitos.";
    }

    // Los dos primeros dígitos deben estar entre 01 y 24, que son las provincias de Ecuador
    $provincia = substr($cedula, 0, 2);
    if ($provincia < 1 || $provincia > 24) {
        return "La cédula no corresponde a una provincia válida.";
    }

    // El tercer dígito debe estar entre 0 y 6 para cédulas de personas naturales
    $tercerDigito = substr($cedula, 2, 1);
    if ($tercerDigito > 6) {
        return "El tercer dígito es inválido.";
    }

    // Aplicar el algoritmo de verificación de cédula
    $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2]; // Coeficientes para multiplicar los primeros 9 dígitos
    $suma = 0;

    // Calcular la suma del algoritmo de verificación
    for ($i = 0; $i < 9; $i++) {
        $valor = (int)$cedula[$i] * $coeficientes[$i];
        if ($valor >= 10) {
            $valor -= 9;
        }
        $suma += $valor;
    }

    // Obtener el dígito verificador
    $digitoVerificador = (10 - ($suma % 10)) % 10;

    // Comparar el dígito verificador con el último dígito de la cédula
    if ($digitoVerificador != (int)$cedula[9]) {
        return "La cédula es inválida.";
    }

    return true; // La cédula es válida
}

// Verificar si es una solicitud AJAX para validar cédula
if (isset($_POST['action']) && $_POST['action'] === 'validar_cedula') {
    // Configurar encabezados para respuesta JSON
    header('Content-Type: application/json');
    
    // Validar cédula
    if (isset($_POST['cedula'])) {
        $resultado = validarCedula($_POST['cedula']);
        
        if ($resultado === true) {
            // Cédula válida
            echo json_encode([
                'valido' => true,
                'mensaje' => 'Cédula válida'
            ]);
        } else {
            // Cédula inválida, devolver mensaje de error
            echo json_encode([
                'valido' => false,
                'mensaje' => $resultado
            ]);
        }
    } else {
        // No se proporcionó cédula
        echo json_encode([
            'valido' => false,
            'mensaje' => 'No se proporcionó número de cédula'
        ]);
    }
    
    exit; // Terminar la ejecución después de enviar la respuesta JSON
}
?>