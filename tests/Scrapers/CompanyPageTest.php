<?php
/**
 * Created by PhpStorm.
 * User: Solomon
 * Date: 7/24/2017
 * Time: 9:54 AM
 */

namespace ByTIC\MFinante\Tests\Scrapers;

use ByTIC\MFinante\Scrapers\CompanyPage;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class CompanyPageTest
 * @package ByTIC\MFinante\Tests\Scrapers
 */
class CompanyPageTest extends TestCase
{
    public function testGetCrawler()
    {
        $scraper = new CompanyPage('32586219');
        $crawler = $scraper->getCrawler();

        static::assertInstanceOf(Crawler::class, $crawler);

        static::assertSame('http://www.mfinante.gov.ro/infocodfiscal.html?cod=32586219', $crawler->getUri());

        static::assertContains('32586219', $crawler->html());
    }
}