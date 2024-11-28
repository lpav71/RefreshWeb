<?php

namespace App\Http\Common;

use Illuminate\Support\Collection;

class Export
{
    /**
     * @param mixed $headTable
     * @param mixed $collection
     * @return string
     */
    public function runExport(mixed $headTable, mixed $collection): string
    {
        $h        = explode(',', $headTable);
        $date     = date('Y-m-d H:i:s');
        $fileName = md5($date) . ".csv";
        header("Content-Type: text/csv; charset=UTF-8");
        header("Content-Disposition: attachment; filename=$fileName");

        $file = fopen("CSV/$fileName", 'w');

        // Устанавливаем кодировку для записи в файл
        fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM

        fputcsv($file, $h, ';');

        // Записываем данные из базы данных
        foreach ($collection as $item) {
            fputcsv($file, (array)$item, ';');
        }

        fclose($file);
        return $fileName;
    }

    /**
     * @param Collection $users
     * @return string
     */
    public function runExportClients(Collection $users): string
    {
        $date     = date('Y-m-d H:i:s');
        $fileName = md5($date) . ".csv";
        header("Content-Type: text/csv; charset=UTF-8");
        header("Content-Disposition: attachment; filename=$fileName");

        $file = fopen("CSV/$fileName", 'w');

        // Устанавливаем кодировку для записи в файл
        //fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM

        // Записываем данные из базы данных
        foreach ($users as $user) {
            fputcsv($file, $user->toArray(), ';');
        }

        fclose($file);
        return $fileName;
    }
}
