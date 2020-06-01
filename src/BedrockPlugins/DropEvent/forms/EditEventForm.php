<?php

namespace BedrockPlugins\DropEvent\forms;

use BedrockPlugins\DropEvent\DropEventPlugin;
use BedrockPlugins\DropEvent\listeners\DropEventListener;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class EditEventForm extends CustomForm {

    public function __construct() {

        $callable = function (Player $player, $data) {

            if ($data === null) return;

            if (!DropEventListener::isEvent()) {

                $player->sendMessage(DropEventPlugin::$prefix . "There is no event. Create one with '/dropevent create'");

                return;

            }

            if (DropEventListener::hasStarted()) {

                $player->sendMessage(DropEventPlugin::$prefix . "The event has already started. Use '/dropevent cancel' to end it");

                return;

            }

            $plot = $data[0];
            $time = $data[1];

            $dropevent = DropEventPlugin::getInstance()->dropevent;

            $dropevent->setCountdown($time*60);
            $dropevent->setPlot($plot);

            $player->sendMessage(DropEventPlugin::$prefix . "The event has been edited");

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