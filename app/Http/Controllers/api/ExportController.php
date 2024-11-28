<?php

namespace App\Http\Controllers\api;

use App\Http\Common\Export;
use App\Http\Common\Import;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Providers\ImportExport;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    protected Import $import;
    protected Export $export;
    protected Client $clientModel;
    protected        $importExport;

    /**
     * @param Import $import
     * @param Export $export
     * @param Client $clientModel
     */
    public function __construct(Import $import, Export $export, Client $clientModel, ImportExport $importExport)
    {
        $this->import       = $import;
        $this->export       = $export;
        $this->clientModel  = $clientModel;
        $this->importExport = $importExport;
    }

    public function export(Request $request): string
    {
        $collection = $request->collection;
        $headTable  = $request->header;
        return $this->export->runExport($headTable, $collection);
    }

    public function exportClients(Request $request): string
    {
        $club_id = $request->club_id;
        $users   = $this->clientModel->clients2($club_id);
        return $this->export->runExportClients($users);
    }

    public function importClients(Request $request)
    {
        $a               = $this->importExport->test();
        $fileName        = $request->filename;
        $file            = fopen($fileName, 'r'); // Открываем файл для чтения
        $ids             = [];
        $clientsFromFile = [];
        $this->import->readCSVFile($file, $clientsFromFile, $ids);
        $clients = $this->clientModel->getAllClientsByIds($ids);
        $this->import->insertNewRecords($clientsFromFile, $clients);
        fclose($file); // Закрываем файл
    }
}
