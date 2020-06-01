<?php

namespace BedrockPlugins\DropEvent\commands;

use BedrockPlugins\DropEvent\DropEvent;
use BedrockPlugins\DropEvent\DropEventPlugin;
use BedrockPlugins\DropEvent\forms\CreateEventForm;
use BedrockPlugins\DropEvent\forms\EditEventForm;
use BedrockPlugins\DropEvent\inventory\DropEventInventory;
use BedrockPlugins\DropEvent\listeners\DropEventListener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class DropEventCommand extends Command {

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = []) {
        $this->setPermission("dropevent.command.execute");
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if (!$sender->hasPermission("dropevent.command.execute") || !$sender instanceof Player) {

            $sender->sendMessage(DropEventPlugin::$prefix . "You don't have permissions to use this command");

            return;

        }

        if (!isset($args[0])) {

            $sender->sendMessage(DropEventPlugin::$prefix . "/dropevent <create/edit/cancel/pos1/pos2/items/start>");

            return;

        }

        $dropevent = DropEventPlugin::getInstance()->dropevent;

        switch ($args[0]) {

            case "setup":
            case "create":

                if (DropEventListener::isEvent()) {

                    $sender->sendMessage(DropEventPlugin::$prefix . "An event has already been created. Use '/dropevent <edit/cancel>' to edit or cancel the current event");

                    break;

                }

                $sender->sendForm(new CreateEventForm());

                break;

            case "edit":

                if (!DropEventListener::isEvent()) {

                    $sender->sendMessage(DropEventPlugin::$prefix . "No event has been crated use '/dropevent create' to create one");

                    break;

                }

                if (DropEventListener::hasStarted()) {

                    $sender->sendMessage(DropEventPlugin::$prefix . "The event has already started. Use '/dropevent cancel' to end it");

                    break;

                }

                $sender->sendForm(new EditEventForm());

                break;

            case "cancel":
            case "end":
            case "stop":

                if (!DropEventListener::isEvent()) {

                    $sender->sendMessage(DropEventPlugin::$prefix . "No event has been crated use '/dropevent create' to create one");

                    break;

                }

                DropEventPlugin::getInstance()->dropevent = null;

                $sender->sendMessage(DropEventPlugin::$prefix . "You have successfully canceled the event");

                DropEventPlugin::getInstance()->getServer()->broadcastMessage(DropEventPlugin::$prefix . "The event has been cancelled", DropEventPlugin::getInstance()->getServer()->getOnlinePlayers());

                break;

            case "pos1":
            case "position1":
            case "posone":
            case "positionone":

                if (!DropEventListener::isEvent()) {

                    $sender->sendMessage(DropEventPlugin::$prefix . "No event has been crated use '/dropevent create' to create one");

                    break;

                }

                if (DropEventListener::hasStarted()) {

                    $sender->sendMessage(DropEventPlugin::$prefix . "The event has already started. Use '/dropevent cancel' to end it");

                    break;

                }

                $position = $sender->asVector3();

                $dropevent->setPos1($position);

                $sender->sendMessage(DropEventPlugin::$prefix . "The first position has been set to " . TextFormat::YELLOW . round($position->getX()) . ":" . round($position->getY()) . ":" . round($position->getZ()));

                break;

            case "pos2":
            case "position2":
            case "postwo":
            case "positiontwo":

                if (!DropEventListener::isEvent()) {

                    $sender->sendMessage(DropEventPlugin::$prefix . "No event has been crated use '/dropevent create' to create one");

                    break;

                }

                if (DropEventListener::hasStarted()) {

                    $sender->sendMessage(DropEventPlugin::$prefix . "The event has already started. Use '/dropevent cancel' to end it");

                    break;

                }

                $position = $sender->asVector3();

                $dropevent->setPos2($position);

                $sender->sendMessage(DropEventPlugin::$prefix . "The second position has been set to " . TextFormat::YELLOW . round($position->getX()) . ":" . round($position->getY()) . ":" . round($position->getZ()));

                break;

            case "items":
            case "item":
            case "inventory":

                if (!DropEventListener::isEvent()) {

                    $sender->sendMessage(DropEventPlugin::$prefix . "No event has been crated use '/dropevent create' to create one");

                    break;

                }

                if (DropEventListener::hasStarted()) {

                    $sender->sendMessage(DropEventPlugin::$prefix . "The event has already started. Use '/dropevent cancel' to end it");

                    break;

                }

                DropEventInventory::sendInventory($sender);

                break;

            case "start":
            case "begin":

                if (!DropEventListener::isEvent()) {

                    $sender->sendMessage(DropEventPlugin::$prefix . "No event has been crated use '/dropevent create' to create one");

                    break;

                }

                if (DropEventListener::hasStarted()) {

                    $sender->sendMessage(DropEventPlugin::$prefix . "The event has already started. Use '/dropevent cancel' to end it");

                    break;

                }

                $sender->sendMessage(DropEventPlugin::$prefix . "You started the event");

                DropEventPlugin::getInstance()->dropevent->setCountdown(1);

                break;

            default:

                $sender->sendMessage(DropEventPlugin::$prefix . "/dropevent <create/edit/cancel/pos1/pos2/items/start>");

                break;

        }

    }

}