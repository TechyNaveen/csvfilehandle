<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class Uploads extends Controller
{
    public function upload(Request $request){

        $filename = $request->img->getClientOriginalName();

        $request->img->move(public_path('uploads'),$filename);
        
        if(File::exists(public_path('uploads/' . $filename)))
        {

            
            if (($handle = fopen(public_path('uploads/' . $filename), 'r')) !== false) {
                while (($csv = fgetcsv($handle)) !== false) {
                    $data[] = $csv[0]; // Collect the first value of each row
                    
                }
                fclose($handle); // Close the file after reading all rows
            }


             return response()->json($data);


        }


    }



    public function exportCsv()
    {
        $data = [
            ['Name', 'Email', 'Age'],
            ['John Doe', 'john@example.com', 28],
            ['Jane Smith', 'jane@example.com', 34],
            // Add more data as needed
        ];

        $fileName = 'users.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8 encoding
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            foreach ($data as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }







}
