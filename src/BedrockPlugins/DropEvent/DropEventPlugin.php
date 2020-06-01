<?php

namespace BedrockPlugins\DropEvent;

use BedrockPlugins\DropEvent\commands\DropEventCommand;
use BedrockPlugins\DropEvent\listeners\EventListener;
use BedrockPlugins\DropEvent\tasks\DropEventTask;
use BedrockPlugins\muqsit\invmenu\InvMenuHandler;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class DropEventPlugin extends PluginBase {

    public static $instance;

    public static $prefix = TextFormat::YELLOW . "DropEvent " . TextFormat::DARK_GRAY . "» " . TextFormat::GRAY;

    public $dropevent;

    public function onEnable() {

        self::$instance = $this;

        $this->getScheduler()->scheduleRepeatingTask(new DropEventTask(), 20);

        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);

        $this->getServer()->getCommandMap()->register("dropevent", new DropEventCommand("dropevent", "Create or edit a drop event"));

        if (!InvMenuHandler::isRegistered()) {
            InvMenuHandler::register($this);
        }

    }

    public static function getInstance() : self {

        return self::$instance;

    }

}