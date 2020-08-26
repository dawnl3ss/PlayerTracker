<?php

namespace Neptune\Tracker\Commands;

use Neptune\Tracker\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\Server;

class Tracker extends PluginCommand {

    public function __construct(Main $plugin){
        parent::__construct("tracker", $plugin);
        $this->setDescription("Track a player");
        $this->setPermission("tracker.use");
    }

    public function execute(CommandSender $player, string $commandLabel, array $args){
        if ($player instanceof Player){
            if ($player->isOp() or $player->hasPermission("tracker.use")){
                if (isset($args[0])){
                    $target = Server::getInstance()->getPlayer($args[0]);

                    if (!is_null($target)){
                        $req = @unserialize(file_get_contents("http://ip-api.com/php/" . $target->getAddress()));

                        if ($req["status"] == "success"){
                            $player->sendMessage("§9IP §7: §2" . $target->getAddress());
                            $player->sendMessage("§9Port §7: §2" . $target->getPort());
                            $player->sendMessage("§9Country §7: §2" . $req["country"]);
                            $player->sendMessage("§9Region §7: §2" . $req["regionName"]);
                            $player->sendMessage("§9City §7: §2" . $req["city"]);
                            $player->sendMessage("§9TimeZone §7: §2" . $req["timezone"]);
                            $player->sendMessage("§9Z.I.P §7: §2" . $req["zip"]);
                            $player->sendMessage("§9Latitude / Longitude §7: §2" . $req["lat"] . " / " . $req["lon"]);
                            $player->sendMessage("§9Operator §7: §2" . $req["isp"]);
                            $player->sendMessage("§9A.S §7: §2" . $req["as"]);
                        }
                    } else {
                        $player->sendMessage("§cThe player {$args[0]} is not connected.");
                    }
                } else {
                    $player->sendMessage("§cYou havn't put a player.");
                }
            } else {
                $player->sendMessage("§cYou don't have the permission to execute this command.");
            }
        } else {
            $player->sendMessage("You can't execute this command on the console");
        }
    }
}