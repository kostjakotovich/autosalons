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
        // Далее ваш существующий код для экспорта в Excel
    }


    // Создайте новый объект Spreadsheet
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

    // Создайте новый лист
    $sheet = $spreadsheet->getActiveSheet();

    // Задайте заголовки для таблицы
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
    $sheet->setCellValue('L1', 'Price');
    $sheet->setCellValue('M1', 'Total Price');

    // Получите данные о заказах пользователя
    $order = new Order();
    $orders = $order->getOrderInfo($userID);

    $row = 2; // Начните с второй строки

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
        $sheet->setCellValue('L' . $row, $order['price']);

        $row++;
    }
    $sheet->setCellValue('M' . $row, $totalSum);

    // Создайте объект Writer для формата Xlsx (Excel)
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    // Определите заголовки и выводите файл в браузер
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $order['username'] . '_orders.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');

    exit; // Завершаем скрипт после отправки файла
}
?>
