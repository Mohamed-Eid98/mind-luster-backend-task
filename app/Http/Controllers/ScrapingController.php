<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScrapingController extends Controller
{
    public function scrapeWebsite()
    {
        //Increase the maximum execution time if needed
        ini_set('max_execution_time', 180);

        $url = 'https://www.kotobati.com/section/%D8%B1%D9%88%D8%A7%D9%8A%D8%A7%D8%AA';

        $client = new Client();
        $crawler = $client->request('GET', $url);    // Make a request to the target URL
        $data = [];   // Array to store the scraped data

        // Extract data using CSS selectors
        $crawler->filter('.book-teaser')->each(function ($node) use (&$data, $client) {
            $title = $node->filter('h3 a')->text();
            $author = $node->filter('p a')->text();
            $link = 'https://www.kotobati.com' . $node->filter('a')->attr('href');


            $bookCrawler = $client->request('GET', $link); // Make another request to the URL of each book 


            $pagesCount = $bookCrawler->filter('.media-body ul li p span')->text();
            $bookLang = $bookCrawler->filter('.media-body ul li p')->eq(2)->text() . ' ' . $bookCrawler->filter('.media-body ul li p')->eq(3)->text();
            $bookSize = $bookCrawler->filter('.media-body ul li p')->eq(5)->text();
            $bookPdfLink = 'https://www.kotobati.com' . $bookCrawler->filter('.row .download')->attr('href');

            // Add the extracted data to the array
            $data[] = [
                'book_title' => $title,
                'book_author' => $author,
                'book_pages_count' => $pagesCount,
                'book_lang' => $bookLang,
                'book_size' => $bookSize,
                'book_file' => $bookPdfLink,
            ];
        });

        // Store the data in the database
        foreach ($data as $bookData) {
            DB::table('books')->insert($bookData);
        }

        return response()->json($data);
    }


}
