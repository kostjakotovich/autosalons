<?php
require '../vendor/autoload.php'; // Путь к autoload.php из PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['export']) && $_POST['export'] === 'true') {
    if (isset($_POST['orders_data'])) {
        $orders = unserialize($_POST['orders_data']);
    } else {
        // Обработка ошибки: данные о заказах отсутствуют
        echo "Error: Orders data is missing.";
        exit;
    }

    // новый объект Spreadsheet
    $spreadsheet = new Spreadsheet();

    // новый лист
    $sheet = $spreadsheet->getActiveSheet();

    // заголовки для таблицы
    $sheet->setCellValue('A1', 'Order ID');
    $sheet->setCellValue('B1', 'Order Date');
    $sheet->setCellValue('C1', 'Name');
    $sheet->setCellValue('D1', 'Surname');
    $sheet->setCellValue('E1', 'Telephone');
    $sheet->setCellValue('F1', 'Username');
    $sheet->setCellValue('G1', 'Email');
    $sheet->setCellValue('H1', 'Manufacturer');
    $sheet->setCellValue('I1', 'Type');
    $sheet->setCellValue('J1', 'Color');
    $sheet->setCellValue('K1', 'Car Price');
    $sheet->setCellValue('L1', 'Color Price');
    $sheet->setCellValue('M1', 'Final Price');
    $sheet->setCellValue('N1', 'Status');

    $row = 2; // Начните с второй строки

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
        $sheet->setCellValue('J' . $row, $order['color']);
        $sheet->setCellValue('K' . $row, $order['price'] . ' $');
        $sheet->setCellValue('L' . $row, $order['color_price'] . ' $');
        $sheet->setCellValue('M' . $row, $order['price'] + $order['color_price'] . ' $');
        $sheet->setCellValue('N' . $row, $order['status']);
        $row++;
    }

    // объект Writer для формата Xlsx (Excel)
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    // заголовки и выводите файл в браузер
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Orders.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');

    exit; // Завершаем скрипт после отправки файла
}
// ...
?>
