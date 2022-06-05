<?php

namespace Afq\CommandShortcut;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase {

    public function onEnable() : void {
		if (!file_exists($this->getDataFolder() . "Config.yml")) {
            $this->config = (new Config($this->getDataFolder() . "Config.yml", Config::YAML, [
                "gamemode" => [
					"Replace" => "gm",
				],
				"version" => [
					"Replace" => "v",
				],
            ]))->getAll();
        } else {
            $this->config = (new Config($this->getDataFolder() . "Config.yml", Config::YAML, []))->getAll();
        }
		$commandMap = $this->getServer()->getCommandMap();
		foreach ($this->config as $commandName => $data) {	
			$existingCommand = $commandMap->getCommand($commandName);
			if ($existingCommand) {
				$commandMap->register($data["Replace"], new $existingCommand($data["Replace"]));
			}
		}
    }

}
