<?php
namespace OhTenPHP\Website\SiteBundle\Tests\Services;

use Endroid\Twitter\Twitter;
use OhTenPHP\Website\SiteBundle\Services\TwitterService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Stash\Pool;

/**
 * Class TwitterServiceTest
 * @package OhTenPHP\Website\SiteBundle\Tests\Services
 */
class TwitterServiceTest extends KernelTestCase
{
    protected $twitterService;

    protected function setUp()
    {
        self::bootKernel();
        $this->twitterService = static::$kernel->getContainer()->get('oh_ten_php_website_site.twitter');
    }

    public function testEnsureTwitterClientInstance()
    {
        $this->assertInstanceOf(TwitterService::class, $this->twitterService);
    }

    public function testGetLatestTweets()
    {
        $expected = [
            ['text' => 'hello world'],
        ];

        $mockeryMock = \Mockery::mock(Twitter::class);
        $mockeryMock
            ->shouldReceive('getTimeline')->once()
            ->andReturn($expected);
        $mockedStashPool = new Pool();

        $service = new TwitterService($mockeryMock, $mockedStashPool);
        $this->assertEquals($expected, $service->getLatestTweets());
    }


    public function tearDown()
    {
        self::ensureKernelShutdown();
        unset($this->twitterService);
    }
}
