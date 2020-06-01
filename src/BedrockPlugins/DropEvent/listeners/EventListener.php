<?php

namespace BedrockPlugins\DropEvent\listeners;

use BedrockPlugins\DropEvent\DropEventPlugin;
use BedrockPlugins\muqsit\invmenu\inventories\DoubleChestInventory;
use pocketmine\event\inventory\InventoryCloseEvent;
use pocketmine\event\Listener;

class EventListener implements Listener {

    public function onInventoryClose(InventoryCloseEvent $event) {

        $player = $event->getPlayer();

        $inv = $event->getInventory();

        if (!$player->hasPermission("dropevent.command.execute")) return;

        if (!DropEventListener::isEvent()) return;
        if (DropEventListener::hasStarted()) return;

        if ($inv instanceof DoubleChestInventory) {

            DropEventPlugin::getInstance()->dropevent->setItems($inv->getContents());

            $player->sendMessage(DropEventPlugin::$prefix . "Items have been saved");

        }

    }

}