<?php


namespace BedrockPlugins\DropEvent\forms;

use BedrockPlugins\DropEvent\DropEvent;
use BedrockPlugins\DropEvent\DropEventPlugin;
use BedrockPlugins\DropEvent\listeners\DropEventListener;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class CreateEventForm extends CustomForm {

    public function __construct() {

        $callable = function (Player $player, $data) {

            if ($data === null) return;

            if (DropEventListener::isEvent()) {

                $player->sendMessage(DropEventPlugin::$prefix . "An event has already been created. Use '/dropevent <edit/cancel>' to edit or cancel the current event");

                return;

            }

            $plot = $data[0];
            $time = $data[1];

            $dropevent = new DropEvent($player, $time*60, $plot);

            DropEventPlugin::getInstance()->dropevent = $dropevent;

            $player->sendMessage(DropEventPlugin::$prefix . "DropEvent has been crated");

            $middle = DropEventPlugin::$prefix . "There is a " . TextFormat::BOLD . TextFormat::GOLD . "DROPEVENT" . TextFormat::RESET . TextFormat::GRAY . " at " . TextFormat::YELLOW . $plot . TextFormat::GRAY .  " starting in " . TextFormat::YELLOW . strval($time) . " minute(s)!";

            $placeholder = TextFormat::OBFUSCATED . TextFormat::BOLD . TextFormat::GOLD . str_repeat("a", 35) . TextFormat::RESET;

            $message = $placeholder . TextFormat::EOL . $middle . TextFormat::EOL . $placeholder;

            DropEventPlugin::getInstance()->getServer()->broadcastMessage($message, DropEventPlugin::getInstance()->getServer()->getOnlinePlayers());

        };

        parent::__construct($callable);

        $this->setTitle("Create DropEvent");

        $this->addInput("Plot / Coordinates", "0;0 / 0:0:0", "0;0");

        $this->addSlider("Minutes until start", 1, 60);

    }

}