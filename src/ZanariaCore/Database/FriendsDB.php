<?php

namespace ZanariaCore\Database;

use ZanariaCore\Core;

class FriendsDB {

    public static function getDB(): \MySQLi{
        return Core::getInstance()->getMySQLi();
    }

    public static function init(): void {
        $db = self::getDB();

        $db->query("CREATE TABLE IF NOT EXISTS friends(author_id INTEGER, target_id INTEGER, is_pending BOOLEAN)");
    }

    public static function getAllDatas(): ?array {
        $db = self::getDB();

        $req = $db->query("SELECT * FROM friends");
        $arr = $req->fetch_array();
        
        return is_null($arr) ? [] : $arr;
    }

    public static function areFriendsPending($id1, $id2): bool {
        $db = self::getDB();

        $req = $db->query("SELECT * FROM friends WHERE (author_id='$id1' AND target_id='$id2' AND is_pending=1) OR (author_id='$id2' AND target_id='$id1' AND is_pending=1)");
        $arr = $req->fetch_array();

        return !is_null($arr) ? true : false;
    }

    public static function areFriends($id1, $id2): bool {
        $db = self::getDB();

        $req = $db->query("SELECT * FROM friends WHERE (author_id='$id1' AND target_id='$id2' AND is_pending=0) OR (author_id='$id2' AND target_id='$id1' AND is_pending=0)");
        $arr = $req->fetch_array();

        return !is_null($arr) ? true : false;
    }

    public static function getTargetDemand($id): array {
        $db = self::getDB();

        $req = $db->query("SELECT * FROM friends WHERE target_id='$id' AND is_pending=1");
        $arr = $req->fetch_array();

        return is_null($arr) ? [] : $arr;
    }

    public static function getSendDemand($id): array {
        $db = self::getDB();

        $req = $db->query("SELECT * FROM friends WHERE author_id='$id' AND is_pending=1");
        $arr = $req->fetch_array();

        return is_null($arr) ? [] : $arr;
    }

    public static function getFriends($id): array {
        $db = self::getDB();

        $req = $db->query("SELECT * FROM friends WHERE (author_id='$id' AND is_pending=0) OR (target_id='$id' AND is_pending=0)");
        $arr = $req->fetch_array();

        return is_null($arr) ? [] : $arr;
    }
}