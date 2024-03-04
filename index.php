<?php

require "vendor/autoload.php";

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

$link = $_GET['link'] ?? 'Sin datos';
$size = $_GET['size'] ?? '300';

$writer = new PngWriter();

$qrCode = QrCode::create($link)
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
    ->setSize($size)
    ->setMargin(10)
    ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
    ->setForegroundColor(new Color(255, 0, 0))
    ->setBackgroundColor(new Color(225, 225, 225))
;

$logo = Logo::create(__DIR__.'/vendor/3318377.png')
    ->setResizeToWidth(50)
;

$label = Label::create('verificador QR V2.0')
    ->setTextColor(new Color(255, 0, 0))
;

$result = $writer->write($qrCode, $logo, $label);

// Imprimir QR
header('Content-Type: '.$result->getMimeType());
echo $result->getString();

/* para guardar el qr localmente
$qrDirectory = 'imageQR';
if (!file_exists($qrDirectory)) {
    mkdir($qrDirectory, 0777, true);
}
$result->saveToFile(__DIR__.'/'. uniqid() .'.png');
*/

// Generar un URI de datos para incluir datos de imagen en línea (es decir, dentro de una etiqueta <img>)
$dataUri = $result->getDataUri();