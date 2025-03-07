<?php

declare(strict_types=1);

namespace Danial\CreativeLimit;



use pocketmine\block\VanillaBlocks;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerGameModeChangeEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\player\GameMode;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config; 
use pocketmine\utils\TextFormat;
use pocketmine\player\Player;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info(TextFormat::GREEN . "Plugin Enabled - By Danial");
    }
    public function onDisable(): void {
        $this->getLogger()->info(TextFormat::RED . "Plugin Disabled");
    }
    public function onInteract(PlayerInteractEvent $event ): void {
        $player = $event->getPlayer();
        $blocks1 = $event->getPlayer()->getInventory()->getItemInHand()->getName();
        $blocks2 = $event->getBlock()->getName();
        $blacklist1 = [
            VanillaBlocks::ENDER_CHEST()->getName(),
            VanillaBlocks::CHEST()->getName(),
            VanillaBlocks::FURNACE()->getName(),
            VanillaBlocks::TRAPPED_CHEST()->getName(),
            VanillaBlocks::ENCHANTING_TABLE()->getName(),
            VanillaBlocks::Anvil()->getName(),
            VanillaBlocks::ITEM_FRAME()->getName(),
            VanillaBlocks::SHULKER_BOX()->getName(),
            VanillaBlocks::SHULKER_BOX()->getName(),
            VanillaBlocks::GOLD()->getName(),
            VanillaBlocks::GOLD_ORE()->getname(),
            VanillaBlocks::IRON()->getName(),
            VanillaBlocks::IRON_ORE()->getName(),
            VanillaBlocks::DIAMOND()->getName(),
            VanillaBlocks::DIAMOND_ORE()->getName(),
            VanillaBlocks::EMERALD()->getName(),
            VanillaBlocks::EMERALD_ORE()->getName()
        ];
        $blacklist2 = [
            VanillaBlocks::CHEST()->getName(),
            VanillaBlocks::TRAPPED_CHEST()->getName(),
            VanillaBlocks::SHULKER_BOX()->getName(),
            ];
        if ($player->isCreative()) {
            if (in_array($blocks1, $blacklist1)) {
                $event->cancel();
            }
            else if (in_array($blocks2, $blacklist2)) {
                $event->cancel();
            }
        }
    }

    public function onGameModeChange(PlayerGameModeChangeEvent $event): void {
        $player = $event->getPlayer();
        $newGM = $event->getNewGamemode();
        if ($newGM === GameMode::SURVIVAL) {
            $player->getInventory()->clearAll();
            $player->getArmorInventory()->clearAll();
        }
    }

    public function onDropItem(PlayerDropItemEvent $event)
    {
        $player = $event->getPlayer();
        if ($player->isCreative()){
            $event->cancel();
        }
    }
        
    public function onPlayerDeath(PlayerDeathEvent $event): void {
        $player = $event->getPlayer();
        if ($player->isCreative()) {
            $player->getInventory()->clearAll();
            $player->getArmorInventory()->clearAll();
        }
    }

}
