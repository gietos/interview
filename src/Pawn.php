<?php

class Pawn extends Figure {
    public function __toString() {
        return $this->isBlack ? '♟' : '♙';
    }

    public function validateMove(Move $move, Desk $desk)
    {

        if (!$move->isForward()) {
            throw new Exception('Pawn can\'t do this move');
        }

        if ($move->getVerticalDistance() > 2) {
            throw new Exception('Pawn can\'t do this move');
        }

        if ($this->getIsMoved() && $move->getVerticalDistance() > 1) {
            throw new Exception('Pawn can\'t do this move');
        }

        if ($move->getHorizontalDistance() === 0 && null !== $desk->getFigure($move->getXTo(), $move->getYTo())) {
            throw new Exception('Can\'t move forward to occupied cell. Move was: ' . (string) $move);
        }

        // @fixme extract this and next check to separate method
        if ($move->getVerticalDistance() > 1 && !$this->isBlack() && null !== $desk->getFigure($move->getXTo(), $move->getYTo() - 1)) {
            throw new Exception('Can\'t move forward over occupied cell');
        }

        // Validate black jump over
        if ($move->getVerticalDistance() > 1 && !$this->isBlack() && null !== $desk->getFigure($move->getXTo(), $move->getYTo() + 1)) {
            throw new Exception('Can\'t move forward over occupied cell');
        }

        // Validate diagonal move distance
        if ($move->getHorizontalDistance() > 1) {
            throw new Exception('Can\'t move diagonally more than one cell');
        }

        // Validate attack
        if ($move->getHorizontalDistance() > 0) {
            $targetFigure = $desk->getFigure($move->getXTo(), $move->getYTo());
            if (null === $targetFigure || $targetFigure->isBlack() === $this->isBlack()) {
                throw new Exception('Can move diagonally only while attack');
            }
        }
    }
}
