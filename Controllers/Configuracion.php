<?php
// Controlador para la gestión de configuraciones y reportes generales
class Configuracion extends Controller
{
    // Constructor: inicia sesión y verifica si el usuario está autenticado
    public function __construct()
    {
        session_start(); // Inicia la sesión
        if (empty($_SESSION['activo'])) {
            // Si no hay sesión activa, redirige al inicio (login)
            header("location: " . base_url);
        }
        parent::__construct(); // Llama al constructor del controlador base
    }

    // Método que carga el panel de administración con estadísticas básicas
    public function admin()
    {
        // Se obtienen conteos de cada entidad del sistema desde el modelo
        $data['libros'] = $this->model->selectDatos('libro');
        $data['materias'] = $this->model->selectDatos('materia');
        $data['estudiantes'] = $this->model->selectDatos('estudiante');
        $data['autor'] = $this->model->selectDatos('autor');
        $data['editorial'] = $this->model->selectDatos('editorial');
        $data['prestamos'] = $this->model->selectDatos('prestamo');
        $data['usuarios'] = $this->model->selectDatos('usuarios');

        // Se carga la vista "home" con todos los datos recopilados
        $this->views->getView($this, "home", $data);
    }

    // Devuelve los datos de reportes para graficar (por ejemplo, barras o tortas)
    public function grafico()
    {
        $data = $this->model->getReportes(); // Consulta los datos estadísticos
        echo json_encode($data); // Devuelve como JSON al frontend
        die();
    }

    // Devuelve datos específicos de préstamos pendientes para gráficos
    public function grafico_pendientes()
    {
        $data = $this->model->getReportespendientes(); // Consulta desde el modelo
        echo json_encode($data); // Envia como JSON
        die();
    }

    // Carga una vista personalizada para mostrar errores del sistema
    public function error()
    {
        $this->views->getView($this, "error");
    }

    // Carga una vista vacía (sin contenido), útil como fallback
    public function vacio()
    {
        $this->views->getView($this, "vacio");
    }

    // Verifica si existen préstamos registrados en la fecha actual
    public function verificar()
    {
        $date = date('Y-m-d'); // Fecha actual
        $data = $this->model->getVerificarPrestamos($date); // Consulta préstamos del día
        echo json_encode($data, JSON_UNESCAPED_UNICODE); // Devuelve JSON con codificación adecuada
        die();
    }

    // Genera un PDF con los préstamos registrados en la fecha actual
    public function libros()
    {
        $datos = $this->model->selectConfiguracion(); // Obtiene datos de configuración general
        $date = date('Y-m-d'); // Fecha actual
        $prestamo = $this->model->getVerificarPrestamos($date); // Obtiene préstamos del día

        // Si no hay préstamos, redirige a vista vacía
        if (empty($prestamo)) {
            header('Location: ' . base_url . 'Configuracion/vacio');
        }

        // Incluye la librería FPDF para generación de documentos PDF
        require_once 'Libraries/pdf/fpdf.php';

        // Se configura el PDF (tamaño carta, orientación vertical)
        $pdf = new FPDF('P', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetTitle("Prestamos");

        // Encabezado del PDF
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(195, 5, utf8_decode($datos['nombre']), 0, 1, 'C');
        $pdf->Image(base_url . "Assets/img/logo.png", 180, 10, 30, 30, 'PNG');

        // Información de contacto (teléfono, dirección, correo)
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, utf8_decode("Teléfono: "), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $datos['telefono'], 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, utf8_decode("Dirección: "), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, utf8_decode($datos['direccion']), 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, "Correo: ", 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, utf8_decode($datos['correo']), 0, 1, 'L');
        $pdf->Ln(); // Salto de línea

        // Título de la tabla
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(0, 0, 0); // Fondo negro
        $pdf->SetTextColor(255, 255, 255); // Texto blanco
        $pdf->Cell(196, 5, "Detalle de Prestamos", 1, 1, 'C', 1);
        $pdf->SetTextColor(0, 0, 0); // Restablece color del texto

        // Encabezados de columna
        $pdf->Cell(14, 5, utf8_decode('N°'), 1, 0, 'L');
        $pdf->Cell(50, 5, utf8_decode('Estudiantes'), 1, 0, 'L');
        $pdf->Cell(87, 5, 'Libros', 1, 0, 'L');
        $pdf->Cell(30, 5, 'Fecha Prestamo', 1, 0, 'L');
        $pdf->Cell(15, 5, 'Cant.', 1, 1, 'L');

        // Cuerpo de la tabla
        $pdf->SetFont('Arial', '', 10);
        $contador = 1;
        foreach ($prestamo as $row) {
            $pdf->Cell(14, 5, $contador, 1, 0, 'L');
            $pdf->Cell(50, 5, $row['nombre'], 1, 0, 'L');
            $pdf->Cell(87, 5, utf8_decode($row['titulo']), 1, 0, 'L');
            $pdf->Cell(30, 5, $row['fecha_prestamo'], 1, 0, 'L');
            $pdf->Cell(15, 5, $row['cantidad'], 1, 1, 'L');
            $contador++;
        }

        // Salida del PDF en el navegador
        $pdf->Output("prestamos.pdf", "I");
    }
}
