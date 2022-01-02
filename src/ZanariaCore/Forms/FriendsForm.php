<?php

namespace ZanariaCore\Forms;

use ZanariaCore\Core;
use pocketmine\player\Player;
use ZanariaCore\Database\FriendsDB;
use ZanariaCore\FormAPI\CustomForm;
use ZanariaCore\FormAPI\SimpleForm;

class FriendsForm {

    public static function menu(Player $player) {
        $form = new SimpleForm(function(Player $player, int $data = null){
            if(is_null($data)) return true;

            switch($data){
                case 0:
                    self::addFriendsForm($player);
                case 1:
                    self::viewFriendsDemandForm($player);
            }
        });

        $form->setTitle('§f§l>> Amis');
        $form->setContent('Voici le menu des amis. Gérez, affichez vos demandes d\'amis reçues et envoyées ainsi que vos amis.');
        $form->addButton('§f§l Envoyer une demande d\'ami');
        $form->addButton('§f§l Afficher les demandes d\'amis que j\'ai reçu');
        $form->addButton('§f§l Afficher les demandes d\'amis que j\'ai envoyé');
        $form->addButton('§f§l Afficher mes amis');
        $form->sendToPlayer($player);
        return $form;
    }

    public static function addFriendsForm(Player $player) {
        $form = new CustomForm(function(Player $player, array $data = null){
            if(is_null($data)) return true;

            $friendToAdd = $data[1];
            if($friendToAdd === $player->getName()) return $player->sendMessage('§c[Amis]§e Vous ne pouvez pas vous ajouter en amis vous-même !');
            $target = Core::getInstance()->getServer()->getPlayerExact($friendToAdd);
            if(is_null($target)) return $player->sendMessage('§e[Amis] §cJoueur introuvable. Réessayez quand celui-ci se connectera.');
            if(FriendsDB::areFriends($player->getName(), $target->getName())) return $player->sendMessage('§c[Amis] §eVous êtes déjà amis !');
            FriendsDB::sendDemand($player->getName(), $target->getName());
            return $player->sendMessage('§e[Amis] §bVous avez ajouté §a' . $target->getName() . '§b en ami !');
        });

        $form->setTitle('§f§l>> Amis');
        $form->addLabel('Ajoutez en ami un joueur et commencez à jouer avec lui !');
        $form->addInput('Nom du joueur', 'Quel joueur voulez-vous ajouter en ami ?');
        $form->sendToPlayer($player);
        return $form;
    }

    public static function viewFriendsDemandForm(Player $player) {
        $form = new SimpleForm(function(Player $player, int $data = null) {
            if(is_null($data)) return null;

            foreach(FriendsDB::getTargetDemand($player->getName()) as $k => $arr){
                switch($data){
                    case $k:
                        return self::manageDemand($arr);
                        break;
                }
            }
        });
        $form->setTitle('§f§l>> Amis');
        $form->setContent('Voici toutes les demandes d\'amis que vous avez reçues.');
        foreach(FriendsDB::getTargetDemand($player->getName()) as $k){
            $target = Core::getInstance()->getServer()->getPlayerExact($k[0]);
            if(is_null($target)) {
                $form->addButton($k[0] . "\n §4⚫ HORS LIGNE");
            }else {
                $form->addButton($k[0] . "\n §2⚫ EN LIGNE");
            }
        }
        $form->sendToPlayer($player);
        return $form;
    }
}