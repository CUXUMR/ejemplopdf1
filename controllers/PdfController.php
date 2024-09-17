<?php

namespace Controllers;

use Model\ActiveRecord;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use MVC\Router;

class PdfController
{
    public static function pdf(Router $router)
    {
        $mpdf = new Mpdf(
            [
                "default_font_size" => "12",
                "default_font" => "arial",
                "orientation" => "P",
                "margin_top" => "30",
                "format" => "Letter"
            ]
        );
        $productos = ActiveRecord::fetchArray("SELECT  
    dv.detalle_id,
    c.cli_nombre AS cliente,
    v.venta_fecha AS fecha_venta,
    p.producto_nombre AS producto,
    dv.detalle_cantidad AS cantidad,
    dv.detalle_situacion AS situacion
FROM 
    detalle_ventas dv
JOIN 
    clientes c ON dv.detalle_cliente = c.cli_id
JOIN 
    ventas v ON dv.detalle_venta = v.venta_id
JOIN 
    productos p ON dv.detalle_producto = p.producto_id");

        $html = $router->load('pdf/reporte', [
            'productos' => $productos
        ]);
        $mpdf->AliasNbPages('[pagetotal]');
        $css = $router->load('pdf/styles');
        $css = file_get_contents(__DIR__ . '/../views/pdf/styles.css');
        $header = $router->load('pdf/header');
        $footer = $router->load('pdf/footer');
        $mpdf->SetHTMLHeader($header);
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($css, HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, HTMLParserMode::HTML_BODY);
        $mpdf->AddPage("L");
        // $mpdf->SetProtection();
        $archivo = $mpdf->Output("reporte.pdf", "I");
        echo base64_encode($archivo);

          // Define la ruta de la carpeta 'temp' en el directorio 'public'
          $publicDir =__DIR__. '../../public/temp'; // Ajusta según la estructura de tu proyecto
          $tempDir = $publicDir . '/temp/';
          $fileName = 'reporte.pdf';
          $filePath = $tempDir . $fileName;
  
          // Asegúrate de que la carpeta 'temp' exista
          if (!is_dir($tempDir)) {
              mkdir($tempDir, 0777, true);
          }
  
          // Guarda el PDF en el archivo especificado
          $mpdf->Output($filePath,'F');
  
    }
}
