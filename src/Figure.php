<?php

class Figure {
    /**
     * @var bool
     */
    protected $isBlack;

    /**
     * @var bool
     */
    protected $isMoved = false;

    public function __construct($isBlack) {
        $this->isBlack = $isBlack;
    }

    /** @noinspection PhpToStringReturnInspection */
    public function __toString() {
        throw new \Exception("Not implemented");
    }

    public function isBlack()
    {
        return $this->isBlack;
    }

    public function validateMove(Move $move, Desk $desk)
    {
        return true;
    }

    public function move()
    {
        $this->isMoved = true;
    }

    public function getIsMoved()
    {
        return $this->isMoved;
    }
}
