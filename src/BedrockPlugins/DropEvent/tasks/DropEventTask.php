<?php

namespace BedrockPlugins\DropEvent\tasks;

use BedrockPlugins\DropEvent\DropEvent;
use BedrockPlugins\DropEvent\DropEventPlugin;
use BedrockPlugins\DropEvent\listeners\DropEventListener;
use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat;

class DropEventTask extends Task {

    public function onRun(int $currentTick) {

        if (!DropEventListener::isEvent()) return;

        $event = DropEventPlugin::getInstance()->dropevent;

        if (!$event instanceof DropEvent) return;

        if (!DropEventListener::hasStarted()) {

            $countdown = $event->getCountdown();

            if ($countdown === 1) {

                $middle = DropEventPlugin::$prefix . "There is a " . TextFormat::BOLD . TextFormat::GOLD . "DROPEVENT" . TextFormat::RESET . TextFormat::GRAY . " starting at " . TextFormat::YELLOW . $event->getPlot();

                $placeholder = TextFormat::OBFUSCATED . TextFormat::BOLD . TextFormat::GOLD . str_repeat("a", 35) . TextFormat::RESET;

                $message = $placeholder . TextFormat::EOL . $middle . TextFormat::EOL . $placeholder;
                DropEventPlugin::getInstance()->getServer()->broadcastMessage($message, DropEventPlugin::getInstance()->getServer()->getOnlinePlayers());

            }

            $countdown--;

            $event->setCountdown($countdown);

            return;

        }

        $creator = $event->getCreator();

        $pos1 = $event->getPos1();
        $pos2 = $event->getPos2();

        if (!$pos1 instanceof Vector3 || !$pos2 instanceof Vector3) {

            DropEventPlugin::getInstance()->dropevent = null;

            if ($creator->isOnline()) {

                $creator->sendMessage(DropEventPlugin::$prefix . "The event has been cancelled because one of the positions wasn't set");

            }

            DropEventPlugin::getInstance()->getServer()->broadcastMessage(DropEventPlugin::$prefix . "The event has been cancelled", DropEventPlugin::getInstance()->getServer()->getOnlinePlayers());

            return;

        }

        $items = $event->getItems();

        if (count($items) <= 0) {

            DropEventPlugin::getInstance()->dropevent = null;

            DropEventPlugin::getInstance()->getServer()->broadcastMessage(DropEventPlugin::$prefix . "The event has been finished", DropEventPlugin::getInstance()->getServer()->getOnlinePlayers());

            return;

        }

        $pos = DropEventListener::getRandomPos();

        if (!$pos instanceof Vector3) {

            DropEventPlugin::getInstance()->dropevent = null;

            if ($creator->isOnline()) {

                $creator->sendMessage(DropEventPlugin::$prefix . "The event has been cancelled because one of the positions wasn't set");

            }

            DropEventPlugin::getInstance()->getServer()->broadcastMessage(DropEventPlugin::$prefix . "The event has been cancelled", DropEventPlugin::getInstance()->getServer()->getOnlinePlayers());

            return;

        }

        $item = array_merge($items)[mt_rand(0, count($items)-1)];

        unset($items[array_search($item, $items)]);

        $event->setItems($items);

        DropEventPlugin::getInstance()->getServer()->getDefaultLevel()->dropItem($pos, $item);

    }

}