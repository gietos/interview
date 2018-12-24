<?php

class Desk {
    private $figures = [];

    /**
     * @var Move
     */
    private $lastMove;

    public function __construct() {
        $this->figures['a'][1] = new Rook(false);
        $this->figures['b'][1] = new Knight(false);
        $this->figures['c'][1] = new Bishop(false);
        $this->figures['d'][1] = new Queen(false);
        $this->figures['e'][1] = new King(false);
        $this->figures['f'][1] = new Bishop(false);
        $this->figures['g'][1] = new Knight(false);
        $this->figures['h'][1] = new Rook(false);

        $this->figures['a'][2] = new Pawn(false);
        $this->figures['b'][2] = new Pawn(false);
        $this->figures['c'][2] = new Pawn(false);
        $this->figures['d'][2] = new Pawn(false);
        $this->figures['e'][2] = new Pawn(false);
        $this->figures['f'][2] = new Pawn(false);
        $this->figures['g'][2] = new Pawn(false);
        $this->figures['h'][2] = new Pawn(false);

        $this->figures['a'][7] = new Pawn(true);
        $this->figures['b'][7] = new Pawn(true);
        $this->figures['c'][7] = new Pawn(true);
        $this->figures['d'][7] = new Pawn(true);
        $this->figures['e'][7] = new Pawn(true);
        $this->figures['f'][7] = new Pawn(true);
        $this->figures['g'][7] = new Pawn(true);
        $this->figures['h'][7] = new Pawn(true);

        $this->figures['a'][8] = new Rook(true);
        $this->figures['b'][8] = new Knight(true);
        $this->figures['c'][8] = new Bishop(true);
        $this->figures['d'][8] = new Queen(true);
        $this->figures['e'][8] = new King(true);
        $this->figures['f'][8] = new Bishop(true);
        $this->figures['g'][8] = new Knight(true);
        $this->figures['h'][8] = new Rook(true);
    }



    public function move(Move $move) {
        $xFrom = $move->getCoords()[1];
        $yFrom = $move->getCoords()[2];
        $xTo   = $move->getCoords()[3];
        $yTo   = $move->getCoords()[4];

        if (!isset($this->figures[$xFrom][$yFrom])) {
            // @todo Write correct exception message
            throw new \Exception(sprintf('Incorrect move: no figure at position'));
        }

        /** @var Figure $figure */
        $figure = $this->figures[$xFrom][$yFrom];
        if (null !== $this->lastMove && $this->lastMove->getFigure()->isBlack() === $figure->isBlack()) {
            // @todo Write correct exception message
            throw new \Exception('Incorrect move order');
        }

        $move->setFigure($figure);
        $figure->validateMove($move, $this);
        $figure->move();

        $this->lastMove = $move;

        if (isset($this->figures[$xFrom][$yFrom])) {
            $this->figures[$xTo][$yTo] = $this->figures[$xFrom][$yFrom];
        }
        $this->figures[$xFrom][$yFrom] = null;
    }

    public function dump() {
        for ($y = 8; $y >= 1; $y--) {
            echo "$y ";
            for ($x = 'a'; $x <= 'h'; $x++) {
                if (isset($this->figures[$x][$y]) && null !== $this->figures[$x][$y]) {
                    echo $this->figures[$x][$y];
                } else {
                    echo '-';
                }
            }
            echo "\n";
        }
        echo "  abcdefgh\n";
    }

    /**
     * @param $x
     * @param $y
     *
     * @return null|Figure
     */
    public function getFigure($x, $y)
    {
        return isset($this->figures[$x][$y]) ? $this->figures[$x][$y] : null;
    }
}
