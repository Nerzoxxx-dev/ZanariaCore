<?php

namespace ZanariaCore\Forms;

use pocketmine\player\Player;
use ZanariaCore\FormAPI\SimpleForm;

class FriendsForm {

    public static function menu(Player $player) {
        $form = new SimpleForm(function(Player $player, int $data = null){
            if(is_null($data)) return true;

            switch($data){

            }
        });

        $form->setTitle('§f§l>> Amis');
        $form->setContent('Voici le menu des amis. Gérez, affichez vos demandes d\'amis reçues et envoyées ainsi que vos amis.');
        $form->addButton('§c§l Afficher les demandes d\'amis que j\'ai reçu');
        $form->addButton('§1§l Afficher les demandes d\'amis que j\'ai envoyé');
        $form->addButton('§2§l Afficher mes amis');
        $form->sendToPlayer($player);
        return $form;
    }

}