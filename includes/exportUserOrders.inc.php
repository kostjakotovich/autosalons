<?php
require '../vendor/autoload.php'; // Путь к autoload.php из PhpSpreadsheet
require_once '../Order.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['export'])) {
    // exportUserOrders.inc.php
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
    $sheet->getStyle('A1:O1')->applyFromArray($styleArray);

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
    $sheet->setCellValue('K1', 'Color');
    $sheet->setCellValue('L1', 'Car Price');
    $sheet->setCellValue('M1', 'Color Price');
    $sheet->setCellValue('N1', 'Final Price');
    $sheet->setCellValue('O1', 'Total Price');

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
        $sheet->setCellValue('K' . $row, $order['color']);
        $sheet->setCellValue('L' . $row, $order['price'] . ' $');
        $sheet->setCellValue('M' . $row, $order['color_price'] . ' $');
        $sheet->setCellValue('N' . $row, $order['price'] + $order['color_price'] . ' $');

        $row++;
    }
    $sheet->setCellValue('O' . $row, $totalSum . ' $');

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $order['username'] . '_orders.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');

    exit;
}
?>
