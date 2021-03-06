<?php

namespace xtakumatutix\suffocation;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\types\GameMode;
use pocketmine\Player;
use pocketmine\block\Block;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

class Main extends PluginBase implements Listener
{
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->notice("読み込み完了 - ver." . $this->getDescription()->getVersion());
    }

    public function onDamage(EntityDamageEvent $event)
    {
        $entity = $event->getEntity();
        if ($entity instanceof Player) {
            $cause = $event->getCause();
            if ($cause === EntityDamageEvent::CAUSE_SUFFOCATION) {
                if (!$entity->getGamemode() == 3) {
                    $y = (int) $entity->getY() + 1;
                    $Vector = new Vector3((int) $entity->getX(), $y, (int) $entity->getFloorZ());
                    if ($entity->getLevel()->getBlock($Vector)->isSolid()) {
                        $event->setCancelled();
                        $entity->teleport($this->getServer()->getLevelByName('lobby')->getSafeSpawn());
                        $entity->sendPopup('§b埋まっていたため、lobbyに戻されました...');
                    }
                }
            }
        }
    }
}
