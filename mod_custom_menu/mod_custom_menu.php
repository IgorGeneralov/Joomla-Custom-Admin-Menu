<?php
/**
 * @version	1.0
 * @package	Admin Custom Menu (admin module)
 * @author	 	Igor Generalov https://generalov.net
 * @copyright  Copyright (c) 2005 - 2025 Igor Generalov. All rights reserved..
 * @license	GNU/GPL: https://gnu.org/licenses/gpl.html
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Registry\Registry;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

$user = Factory::getUser();
?>
<style>
.new-menu {
	border: solid 1px var(--main-nav-item-title);
	margin: 2px 5px;
}

.new-menu-item {
	max-width: 15.2rem;
}
</style>

<?php

if (is_string($module->params)) {
	$params = new Registry($module->params);
} else {
	$params = $module->params;
}
$titleDefault = htmlspecialchars($params->get('titleDefault', ''));
$iconDefault = htmlspecialchars($params->get('iconDefault', ''));
$enable = htmlspecialchars($params->get('enable', ''));

$defaultPosition = $params->get('module_position', 'menu');
if ($module->position !== $defaultPosition) {
	return;
}
?>
<div class="new-menu">
	<ul class="nav flex-column main-nav metismenu">
		<?php		
		// Вывод первого пункта меню из секции "basic"
		if ($enable == 1) { // Если включён
			$accessDefault = $params->get('accessDefault', 8);
			if ($user->authorise('core.view', $accessDefault)) { ?>
				<li class="item item-level-1 new-menu-item">
					<a class="no-dropdown" href="index.php?option=com_modules&view=modules&client_id=1&filter[search]=Custom Admin Menu" aria-label="<?php print $titleDefault; ?>">
						<span class="<?php print $iconDefault; ?> icon-fw" aria-hidden="true"></span>
						<span class="sidebar-item-title"><?php print $titleDefault; ?></span>
					</a>
				</li>
			<?php }
		}		
		$menu_items = $params->get('menu_items', []);
		// Вывод дополнительных пунктов меню из параметров модуля
		foreach ($menu_items as $item) {
			// Получаем уровень доступа для текущего пункта меню
			$access = isset($item->access) ? $item->access : 1;

			// Проверяем права пользователя
			if ($user->authorise('core.view', $access)) {
				$link = htmlspecialchars($item->link);
				$title = htmlspecialchars($item->title ?? '');
				$icon = htmlspecialchars($item->icon ?? 'icon-mail'); ?>
				<li class="item item-level-1 new-menu-item">
					<a class="no-dropdown" href="<?php print $link; ?>" aria-label="<?php print $title; ?>">
						<span class="<?php print $icon; ?> icon-fw" aria-hidden="true"></span>
						<span class="sidebar-item-title"><?php print $title; ?></span>
					</a>
				</li>
			<?php }
		} ?>
	</ul>
</div>