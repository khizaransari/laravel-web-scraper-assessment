<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Jobs\ScrapeMoviesJob;

class ScrapeController extends Controller
{
    /**
     * Trigger the scraping job.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function scrape()
    {
        try {
            dispatch(new ScrapeMoviesJob());
            return $this->successResponse('Scraping job dispatched successfully');
        } catch (\Exception $e) {
            $this->logException($e);
            return $this->errorResponse('An error occurred while processing your request. Please try again later.');
        }
    }

    /**
     * Log the exception.
     *
     * @param \Exception $exception
     * @return void
     */
    private function logException(\Exception $exception)
    {
        Log::error('Scraping job failed: ' . $exception->getMessage());
    }

    /**
     * Return a success response.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    private function successResponse(string $message)
    {
        return response()->json(['message' => $message]);
    }

    /**
     * Return an error response.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    private function errorResponse(string $message)
    {
        return response()->json(['error' => $message], 500);
    }
}
