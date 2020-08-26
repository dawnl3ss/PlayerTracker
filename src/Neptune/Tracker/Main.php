<?php

namespace Neptune\Tracker;

use Neptune\Tracker\Commands\Tracker;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    public function onEnable(){
        $this->getServer()->getCommandMap()->register("tracker", new Tracker($this));
    }
}