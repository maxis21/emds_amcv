<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

class WebScrapingController extends Controller
{

    public function phPDF(){

        $client = HttpClient::create();
        $response = $client->request('GET', 'https://www.philhealth.gov.ph/downloads/membership/pmrf_012020.pdf');

        if($response->getStatusCode() === 200){

            $content = $response->getContent();
            // $destination = 'C:\\Users\\CMU\\Downloads\\philhealth.pdf';
            // file_put_contents($destination, $content);
            Storage::disk('public')->put('This_is_a_philhealth_file.pdf', $content);
            echo "Document fetched and saved to Downloads folder";
        }
        else{
            echo "Failed to fetch the document. Status code: " . $response->getStatusCode();
        }

    }

}
