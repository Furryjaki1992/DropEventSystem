<?php

namespace BedrockPlugins\DropEvent\inventory;

use BedrockPlugins\DropEvent\DropEventPlugin;
use BedrockPlugins\muqsit\invmenu\inventories\DoubleChestInventory;
use BedrockPlugins\muqsit\invmenu\InvMenu;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class DropEventInventory {

    private static $menu;

    public static function getMenu()  {
        return self::$menu;
    }

    public static function sendInventory(Player $player) {

        $menu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);

        $menu->setName(TextFormat::YELLOW . "DropEvent");
        $menu->readonly(false);

        $menu->getInventory()->setContents(DropEventPlugin::getInstance()->dropevent->getItems());

        $menu->setListener(function (Player $player, Item $itemClicked, Item $itemClickedWith, SlotChangeAction $action) : bool {

            return true;

        });

        self::$menu = $menu;

        $menu->send($player);

    }

}