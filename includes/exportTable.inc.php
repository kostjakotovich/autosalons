<?php
require '../vendor/autoload.php'; // Путь к autoload.php из PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['export']) && $_POST['export'] === 'true') {
    if (isset($_POST['orders_data'])) {
        $orders = unserialize($_POST['orders_data']);
    } else {
        echo "Error: Orders data is missing.";
        exit;
    }

    $spreadsheet = new Spreadsheet();

    $sheet = $spreadsheet->getActiveSheet();

    $styleArray = [
        'font' => [
            'bold' => true,
            'color' => ['rgb' => '000000'],
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'FFFF00'],
        ],
    ];
    $sheet->getStyle('A1:T1')->applyFromArray($styleArray);

    $sheet->setCellValue('A1', 'Order ID');
    $sheet->setCellValue('B1', 'Order Date');
    $sheet->setCellValue('C1', 'Name');
    $sheet->setCellValue('D1', 'Surname');
    $sheet->setCellValue('E1', 'Telephone');
    $sheet->setCellValue('F1', 'Username');
    $sheet->setCellValue('G1', 'Email');
    $sheet->setCellValue('H1', 'Manufacturer');
    $sheet->setCellValue('I1', 'Type');
    $sheet->setCellValue('J1', 'Year of Manufacture');
    $sheet->setCellValue('K1', 'Body Type');
    $sheet->setCellValue('L1', 'Transmission');
    $sheet->setCellValue('M1', 'Engine Type');
    $sheet->setCellValue('N1', 'Color');
    $sheet->setCellValue('O1', 'Car Price');
    $sheet->setCellValue('P1', 'Transmission Price');
    $sheet->setCellValue('Q1', 'Engine Price');
    $sheet->setCellValue('R1', 'Color Price');
    $sheet->setCellValue('S1', 'Final Price');
    $sheet->setCellValue('T1', 'Status');

    $row = 2;

    foreach ($orders as $order) {
        $sheet->setCellValue('A' . $row, $order['orderID']);
        $sheet->setCellValue('B' . $row, $order['orderDate']);
        $sheet->setCellValue('C' . $row, $order['name']);
        $sheet->setCellValue('D' . $row, $order['surname']);
        $sheet->setCellValue('E' . $row, $order['telephone']);
        $sheet->setCellValue('F' . $row, $order['username']);
        $sheet->setCellValue('G' . $row, $order['email']);
        $sheet->setCellValue('H' . $row, $order['manufacturer']);
        $sheet->setCellValue('I' . $row, $order['type']);
        $sheet->setCellValue('J' . $row, $order['yearOfManufacture']);
        $sheet->setCellValue('K' . $row, $order['body_type']);
        $sheet->setCellValue('L' . $row, $order['transmission_type']);
        $sheet->setCellValue('M' . $row, $order['engine_type']);
        $sheet->setCellValue('N' . $row, $order['color']);
        $sheet->setCellValue('O' . $row, $order['price'] . ' €');
        $sheet->setCellValue('P' . $row, $order['transmission_price'] . ' €');
        $sheet->setCellValue('Q' . $row, $order['engine_price'] . ' €');
        $sheet->setCellValue('R' . $row, $order['color_price'] . ' €');
        $sheet->setCellValue('S' . $row, $order['price'] + $order['color_price'] + $order['transmission_price'] + $order['engine_price'] . ' €');
        $sheet->setCellValue('T' . $row, $order['status']);
        $row++;
    }

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Orders.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');

    exit;
}
// ...
?>
