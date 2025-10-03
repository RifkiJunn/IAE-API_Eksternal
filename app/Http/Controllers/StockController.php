<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    public function index(Request $request)
        {
        $client = new Client();
        $apiKey = env('STOCK_API_KEY');  // Fetch API key from .env

        // Default to 'AAPL' if no symbol is provided
        $symbol = $request->query('symbol', 'AAPL');

        try {
            // Request data from Alpha Vantage API
            $response = $client->get('https://www.alphavantage.co/query', [
                'query' => [
                    'function' => 'TIME_SERIES_DAILY',
                    'symbol' => $symbol,
                    'apikey' => $apiKey,
                ],
            ]);

            // Get the response body and log it for debugging
            $responseBody = $response->getBody();
            Log::info("API Response: " . $responseBody);  // Log the raw response

            // Decode the JSON response
            $data = json_decode($responseBody, true);

            // Check if the response contains the necessary time series data
            if (isset($data['Time Series (Daily)'])) {
                $timeSeries = $data['Time Series (Daily)'];

                // Prepare data for the chart
                $labels = [];
                $openPrices = [];
                $highPrices = [];
                $lowPrices = [];
                $closePrices = [];

                foreach ($timeSeries as $date => $values) {
                    $labels[] = $date;
                    $openPrices[] = (float) $values['1. open'];
                    $highPrices[] = (float) $values['2. high'];
                    $lowPrices[] = (float) $values['3. low'];
                    $closePrices[] = (float) $values['4. close'];
                }

                // Return data to the view with the current symbol
                return view('welcome', compact('labels', 'openPrices', 'highPrices', 'lowPrices', 'closePrices', 'symbol'));
            } else {
                // If no data is found, show an error message
                Log::error("No time series data found for symbol: " . $symbol);  // Log the error
                $errorMessage = 'No data available for this stock symbol.';
                return view('welcome', compact('errorMessage', 'symbol'));
            }
        } catch (\Exception $e) {
            // Handle any API or connection errors
            Log::error("Error fetching stock data: " . $e->getMessage());
            $errorMessage = 'Error fetching stock data. Please try again later.';
            return view('welcome', compact('errorMessage', 'symbol'));
        }
    }


}
