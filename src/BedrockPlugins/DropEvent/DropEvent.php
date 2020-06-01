<?php

namespace BedrockPlugins\DropEvent;

use pocketmine\math\Vector3;
use pocketmine\Player;

class DropEvent {

    public $creator,
        $countdown,
        $plot,
        $pos1,
        $pos2,
        $items = [];

    public function __construct(Player $creator, int $countdown, $plot) {

        $this->creator = $creator;
        $this->countdown = $countdown;
        $this->plot = $plot;

    }

    public function getCreator() : Player {
        return $this->creator;
    }

    public function getCountdown() {
        return $this->countdown;
    }

    public function getPlot() {
        return $this->plot;
    }

    public function getItems() {
        return $this->items;
    }

    public function getPos1() {
        return $this->pos1;
    }

    public function getPos2() {
        return $this->pos2;
    }



    public function setCreator(Player $player) {
        $this->creator = $player;
    }

    public function setCountdown(int $countdown) {
        $this->countdown = $countdown;
    }

    public function setPlot($plot) {
        $this->plot = $plot;
    }

    public function setItems(array $items) {
        $this->items = $items;
    }

    public function setPos1(Vector3 $pos) {
        $this->pos1 = $pos;
    }

    public function setPos2(Vector3 $pos) {
        $this->pos2 = $pos;
    }

}