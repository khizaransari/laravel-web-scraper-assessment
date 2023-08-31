<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Jobs\ScrapeMoviesJob;
use App\Models\Movie;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class ScrapeMoviesJobTest extends TestCase
{
    use RefreshDatabase;


    public function setUp(): void
    {
        parent::setUp();

        // Clear the database before each test
        Artisan::call('migrate:refresh');
    }

    public function testScrapeMoviesJob()
    {
        $imdb_url = Config::get('app.movies.imdb_url');

        Movie::factory(10)->create();

        // Disable the actual queue
        Queue::fake();

        Http::fake([
            $imdb_url => [],
        ]);

        dispatch(new ScrapeMoviesJob());
        Queue::assertPushed(ScrapeMoviesJob::class);

        // Assert insure 10 movies inserted
        $this->assertDatabaseCount('movies', 10);

        Movie::factory()->create([
            'title' => 'The Shawshank Redemption',
            'year' => '1994',
            'rating' => 9.3,
            'url' => $imdb_url . '/title/tt0111161/',
        ]);

        $movie = Movie::where('title', 'The Shawshank Redemption')->first();
        $this->assertEquals('1994', @$movie->year);
        $this->assertEquals(9.3, $movie->rating);
        $this->assertEquals($imdb_url . '/title/tt0111161/', $movie->url);
    }


    public function testScrapeMoviesJobHandlesException()
    {
        // Mock an exception during scraping
        Http::fake([
            '*' => Http::response('', 500), // Return a 500 Internal Server Error status code
        ]);

        Config::set('app.movies.imdb_url', 'providing wron url');

        // Dispatch the job
        dispatch(new ScrapeMoviesJob());

        // Assert that no movies were inserted
        $this->assertCount(0, Movie::all());
    }

    public function testScrapeMoviesJobHandlesDuplicateMovie()
    {
        // Create two movies with the same title
        Movie::factory(2)->create(['title' => 'The Shawshank Redemption']);
        // Dispatch the job
        dispatch(new ScrapeMoviesJob());
        // Assert that there are duplicate titles in the database
        $hasDuplicateTitles = Movie::hasDuplicateTitles()->exists();
        // Assert that the duplicates exist
        $this->assertTrue($hasDuplicateTitles);
    }
}
