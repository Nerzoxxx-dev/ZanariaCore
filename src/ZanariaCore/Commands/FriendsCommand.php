<?php

namespace ZanariaCore\Commands;

use ZanariaCore\Core;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use ZanariaCore\Forms\FriendsForm;

class FriendsCommand extends Command {

    /** @var Core */
    private Core $core;

    /** @var string  */
    private string $name = "friends";

    /** @var string */
    private string $prefix = "§e[Amis]";

    /** @var string */
    private string $usage = "§cUtilisez /friends help !";

    /** @var array */
    private array $aliases = ['amis'];

    public function __construct(Core $core) {
        parent::__construct($this->name, $this->description, $this->usage, $this->aliases);
        $this->core = $core;
    }

    public function execute(CommandSender $player, string $commandLabel, array $args){

        if(!$player instanceof Player) return $player->sendMessage($this->prefix . ' §cVeuillez utiliser cette commande en jeu !');

        if(!isset($args[0])) return FriendsForm::menu($player);
    }
}