<?php

namespace ByTIC\MFinante\Parsers;

use ByTIC\MFinante\Models\AbstractModel;
use ByTIC\MFinante\Scrapers\AbstractScraper;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AbstractParser
 * @package ByTIC\MFinante\Parsers
 */
abstract class AbstractParser
{

    /**
     * @var AbstractScraper
     */
    protected $scraper;

    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * @var null|boolean
     */
    protected $isValidContent = null;

    /**
     * @var null|array
     */
    protected $contents = null;

    /**
     * @return mixed
     */
    public function getContent()
    {
        if ($this->contents === null) {
            if ($this->isValidContent()) {
                $this->contents = $this->generateContent();
            } else {
                $this->contents = false;
            }
        }

        return $this->contents;
    }

    abstract protected function generateContent();

    /**
     * @return bool|null
     */
    public function isValidContent()
    {
        if ($this->isValidContent == null) {
            $this->isValidContent = $this->doValidation();
        }

        return $this->isValidContent;
    }

    /**
     * @return boolean
     */
    protected function doValidation()
    {
        return true;
    }

    /**
     * @return AbstractScraper
     */
    public function getScraper()
    {
        return $this->scraper;
    }

    /**
     * @param AbstractScraper $scraper
     */
    public function setScraper($scraper)
    {
        $this->scraper = $scraper;
    }

    /**
     * @return Crawler
     */
    public function getCrawler(): Crawler
    {
        return $this->crawler;
    }

    /**
     * @param Crawler $crawler
     */
    public function setCrawler(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return $this->getContent();
    }

    public function getModel()
    {
        $model = $this->getNewModel();
        $parameters = $this->getContent();
        $model->setParameters($model);
    }

    /**
     * @return AbstractModel
     */
    public function getNewModel()
    {
        $className = $this->getModelClassName();
        $model = new $className();
        return $model;
    }

    abstract public function getModelClassName();
}
