<?php

namespace App\Controllers;

use App\Entities\Transaction;
use App\Routing\Request;
use App\Routing\Response;
use App\Views\View;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use App\Services\TransactionFileService;

class FileController extends Controller
{
    public function upload()
    {
        $filename = $this->response->getAttribute('uploaded_filename');
        $service = new TransactionFileService();
        $data = $service->getDataFromTransactionFile($filename);
        $collection = $service->prepareTransactionsCollection($data);
    }

    public function index()
    {
        return (string)View::make('file/index');
    }
}