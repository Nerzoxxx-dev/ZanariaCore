<?php

namespace ZanariaCore;

// PMMP
use pocketmine\plugin\PluginBase;

//Commands
use ZanariaCore\Commands\FriendsCommand;

// DB
use ZanariaCore\Database\FriendsDB;

class Core extends PluginBase {

    public static $db;

    public static $instance;
    
    public function onEnable(): void {
        $this->getServer()->getLogger()->info('Plugin enable!');

        //Init variables
        self::$db = new \MySQLi('127.0.0.1', 'zanaria', 'zanariamc', 'zanaria');
        self::$instance = $this;

        //Register Commands
        $this->getServer()->getCommandMap()->registerAll('zanaria', [
            new FriendsCommand($this)
        ]);
    
        //Init DB
        FriendsDB::init();

    }

    public function onDisable(): void {
        $this->getServer()->getLogger()->info('Plugin disable!');
    }

    public function getMySQLi(): \MySQLi {
        return self::$db;
    }

    public static function getInstance(): self {
        return self::$instance;
    }
}