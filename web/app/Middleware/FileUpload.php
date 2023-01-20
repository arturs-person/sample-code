<?php

namespace App\Middleware;

use App\Routing\Request;
use App\Routing\Response;

class FileUpload
{
    public function handle(Request $request, Response $response): Response
    {
        $file = $request->getFiles();
        move_uploaded_file(
            $file['file']['tmp_name'],
            STORAGE_PATH . '/' . $file['file']['name']
        );
        $response->setAttribute('uploaded_filename', $file['file']['name']);
        return $response;
    }
}