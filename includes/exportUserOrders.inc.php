<?php
require '../vendor/autoload.php'; 
require_once '../Order.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['export'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['export'])) {
        $userID = $_POST['userID'];
        $totalSum = $_POST['totalSum'];
    }

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

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
    $sheet->getStyle('A1:U1')->applyFromArray($styleArray);

    $sheet->setCellValue('A1', 'Order ID');
    $sheet->setCellValue('B1', 'Order Date');
    $sheet->setCellValue('C1', 'Name');
    $sheet->setCellValue('D1', 'Surname');
    $sheet->setCellValue('E1', 'Telephone');
    $sheet->setCellValue('F1', 'Status');
    $sheet->setCellValue('G1', 'Username');
    $sheet->setCellValue('H1', 'Email');
    $sheet->setCellValue('I1', 'Manufacturer');
    $sheet->setCellValue('J1', 'Type');
    $sheet->setCellValue('K1', 'Year of Manufacture');
    $sheet->setCellValue('L1', 'Body Type');
    $sheet->setCellValue('M1', 'Transmission');
    $sheet->setCellValue('N1', 'Engine Type');
    $sheet->setCellValue('O1', 'Color');
    $sheet->setCellValue('P1', 'Car Price');
    $sheet->setCellValue('Q1', 'Transmission Price');
    $sheet->setCellValue('R1', 'Engine Price');
    $sheet->setCellValue('S1', 'Color Price');
    $sheet->setCellValue('T1', 'Final Price');
    $sheet->setCellValue('U1', 'Total Price');

    $order = new Order();
    $orders = $order->getOrderInfo($userID);

    $row = 2;

    foreach ($orders as $order) {
        $sheet->setCellValue('A' . $row, $order['orderID']);
        $sheet->setCellValue('B' . $row, $order['orderDate']);
        $sheet->setCellValue('C' . $row, $order['name']);
        $sheet->setCellValue('D' . $row, $order['surname']);
        $sheet->setCellValue('E' . $row, $order['telephone']);
        $sheet->setCellValue('F' . $row, $order['status']);
        $sheet->setCellValue('G' . $row, $order['username']);
        $sheet->setCellValue('H' . $row, $order['email']);
        $sheet->setCellValue('I' . $row, $order['manufacturer']);
        $sheet->setCellValue('J' . $row, $order['type']);
        $sheet->setCellValue('K' . $row, $order['yearOfManufacture']);
        $sheet->setCellValue('L' . $row, $order['body_type']);
        $sheet->setCellValue('M' . $row, $order['transmission_type']);
        $sheet->setCellValue('N' . $row, $order['engine_type']);
        $sheet->setCellValue('O' . $row, $order['color']);
        $sheet->setCellValue('P' . $row, $order['price'] . ' €');
        $sheet->setCellValue('Q' . $row, $order['transmission_price'] . ' €');
        $sheet->setCellValue('R' . $row, $order['engine_price'] . ' €');
        $sheet->setCellValue('S' . $row, $order['color_price'] . ' €');
        $sheet->setCellValue('T' . $row, $order['price'] + $order['color_price'] + $order['transmission_price'] + $order['engine_price'] . ' €');

        $row++;
    }
    $sheet->setCellValue('U' . $row, $totalSum . ' €');

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $order['username'] . '_orders.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');

    exit;
}
?>
