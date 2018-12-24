<?php

class Move
{
    const DIRECTION_S = 1;
    const DIRECTION_W = 2;
    const DIRECTION_N = 3;
    const DIRECTION_E = 4;
    const DIRECTION_SW = 5;
    const DIRECTION_NW = 6;
    const DIRECTION_NE = 7;
    const DIRECTION_SE = 8;

    const ASCII_OFFSET = 96;

    /**
     * @var Figure
     */
    private $figure;

    /**
     * @var array
     */
    private $coords;

    public function __construct($string)
    {
        $this->coords = $this->parseMove($string);
    }

    protected function parseMove($move)
    {
        if (!preg_match('/^([a-h])(\d)-([a-h])(\d)$/', $move, $matches)) {
            throw new \Exception("Incorrect move");
        }

        return $matches;
    }

    public function setFigure(Figure $figure)
    {
        $this->figure = $figure;
    }

    /**
     * @return array
     */
    public function getCoords()
    {
        return $this->coords;
    }

    public function getXFrom()
    {
        return $this->coords[1];
    }

    public function getYFrom()
    {
        return $this->coords[2];
    }

    public function getXTo()
    {
        return $this->coords[3];
    }

    public function getYTo()
    {
        return $this->coords[4];
    }

    public function isForward()
    {
        if (!isset($this->figure)) {
            throw new \Exception('Couldn\'t get direction before figure is set');
        }

        $yFrom = $this->coords[2];
        $yTo   = $this->coords[4];

        if ($yFrom != $yTo) {
            return $yFrom < $yTo && !$this->figure->isBlack()
                || $yFrom > $yTo && $this->figure->isBlack();
        }

        return false;
    }

    public function getVerticalDistance()
    {
        return abs($this->getYTo() - $this->getYFrom());
    }

    private function getValue($letter)
    {
        return ord($letter) - self::ASCII_OFFSET;
    }

    public function getHorizontalDistance()
    {
        return abs($this->getValue($this->getXTo()) - $this->getValue($this->getXFrom()));
    }

    public function getFigure(): Figure
    {
        return $this->figure;
    }

    public function __toString()
    {
        return join(',', $this->coords);
    }
}