<?php

namespace ByTIC\MFinante\Scrapers;

use ByTIC\MFinante\Helper;
use ByTIC\MFinante\Exception\InvalidCifException;

/**
 * Class CompanyPage
 * @package ByTIC\MFinante\Scrapers
 */
class CompanyPage extends AbstractScraper
{
    /**
     * @var int
     */
    protected $cif;

    /**
     * CompanyPage constructor.
     * @param int $cif
     */
    public function __construct($cif)
    {
        $this->setCif($cif);
    }

    /**
     * @return int
     */
    public function getCif()
    {
        return $this->cif;
    }

    /**
     * @param int $cif
     */
    public function setCif($cif)
    {
        $this->cif = $cif;
    }

    /**
     * @inheritdoc
     */
    protected function generateCrawler()
    {
        if (!Helper::validateCif($this->getCif())) {
            throw new InvalidCifException();
        }
        $crawler = $this->getClient()->request(
            'GET',
            'http://www.mfinante.gov.ro/infocodfiscal.html?cod=' . $this->getCif()
        );
        return $crawler;
    }
}