<?php

namespace StatamicRadPack\Runway\Tests\Console\Commands;

use Illuminate\Support\Facades\Config;
use StatamicRadPack\Runway\Runway;
use StatamicRadPack\Runway\Tests\Fixtures\Models\Author;
use StatamicRadPack\Runway\Tests\Fixtures\Models\Post;
use StatamicRadPack\Runway\Tests\TestCase;

class ListResourcesTest extends TestCase
{
    /** @test */
    public function it_lists_resources()
    {
        $this
            ->artisan('runway:resources')
            ->expectsTable(
                ['Handle', 'Model', 'Route'],
                [
                    ['post', Post::class, '/posts/{{ slug }}'],
                    ['author', Author::class, 'N/A'],
                ]
            );
    }

    /** @test */
    public function it_outputs_error_when_no_resources_exist()
    {
        Config::set('runway.resources', []);
        Runway::discoverResources();

        $this
            ->artisan('runway:resources')
            ->expectsOutput("Your application doesn't have any resources.");
    }
}
