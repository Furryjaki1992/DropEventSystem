<?php

namespace BedrockPlugins\DropEvent\listeners;

use BedrockPlugins\DropEvent\DropEvent;
use BedrockPlugins\DropEvent\DropEventPlugin;
use pocketmine\math\Vector3;

class DropEventListener {

    public static function isEvent() : bool {
        return DropEventPlugin::getInstance()->dropevent instanceof DropEvent;
    }

    public static function hasStarted() : bool {
        if (!self::isEvent()) return false;
        return DropEventPlugin::getInstance()->dropevent->getCountdown() <= 0;
    }

    public static function getRandomPos() {

        if (!self::isEvent()) return null;

        $pos1 = DropEventPlugin::getInstance()->dropevent->getPos1();
        $pos2 = DropEventPlugin::getInstance()->dropevent->getPos2();

        if ($pos1 === null || $pos2 === null) return;

        $x = mt_rand(min($pos1->getX(), $pos2->getX()), max($pos1->getX(), $pos2->getX()));
        $y = mt_rand(min($pos1->getY(), $pos2->getY()), max($pos1->getY(), $pos2->getY()));
        $z = mt_rand(min($pos1->getZ(), $pos2->getZ()), max($pos1->getZ(), $pos2->getZ()));

        return new Vector3($x, $y, $z);

    }

}