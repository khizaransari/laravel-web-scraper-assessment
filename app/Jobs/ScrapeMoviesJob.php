<?php

namespace App\Jobs;

use Goutte;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Movie;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;

class ScrapeMoviesJob implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;

    public $tries = 3;
    public $retryAfter = 60;
    public function handle()
    {
        try {
            $movies = $this->scrapeMoviesFromIMDb();
            $this->saveMoviesToDatabase($movies);
        } catch (RequestException $e) {
            report($e);
            throw new \Exception('Failed to connect to IMDb. Please try again later.');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function scrapeMoviesFromIMDb()
    {
        $crawler = Goutte::request('GET', Config::get('app.movies.imdb_url') . '/chart/top');
        return $crawler->filter('.ipc-metadata-list li')->slice(0, 10)->each(function ($node) {
            $title = $node->filter('.ipc-title__text')->text();
            $year = $node->filter('.cli-title-metadata-item')->eq(0)->text();
            // Extract the numeric rating
            $rating = $node->filter('.ipc-rating-star--imdb')->attr('aria-label');
            $rating = floatval(preg_replace('/[^0-9.]/', '', $rating));
            $url = 'https://www.imdb.com' . $node->filter('.ipc-title-link-wrapper')->attr('href');
            return compact('title', 'year', 'rating', 'url');
        });
    }

    private function saveMoviesToDatabase($movies)
    {
        foreach ($movies as $movie) {
            Movie::updateOrCreate(
                ['title' => $movie['title']],
                [
                    'year' => $movie['year'],
                    'rating' => $movie['rating'],
                    'url' => $movie['url'],
                ]
            );
        }
    }
}
