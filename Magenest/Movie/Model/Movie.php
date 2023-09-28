<?php

namespace Magenest\Movie\Model;

use Magento\Framework\Model\AbstractModel;
use Magenest\Movie\Api\Data\MovieInterface;
use Magenest\Movie\Model\ResourceModel\Movie as ResourceModel;

class Movie extends AbstractModel implements MovieInterface
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getMovieId()
    {
        return $this->_getData(self::MOVIE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setMovieId(int $id)
    {
        return $this->setData(self::MOVIE_ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getMovieName()
    {
        return $this->_getData(self::MOVIE_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setMovieName(string $name)
    {
        return $this->setData(self::MOVIE_NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getMovieDescription()
    {
        return $this->_getData(self::MOVIE_DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setMovieDescription(string $description)
    {
        return $this->setData(self::MOVIE_DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function getMovieRating()
    {
        return $this->_getData(self::MOVIE_RATING);
    }

    /**
     * @inheritDoc
     */
    public function setMovieRating(int $rating)
    {
        return $this->setData(self::MOVIE_RATING, $rating);
    }

    /**
     * @inheritDoc
     */
    public function getMovieDirectorId()
    {
        return $this->_getData(self::MOVIE_DIRECTOR_ID);
    }

    /**
     * @inheritDoc
     */
    public function setMovieDirectorId(int $directorId)
    {
        return $this->setData(self::MOVIE_DIRECTOR_ID, $directorId);
    }
}
