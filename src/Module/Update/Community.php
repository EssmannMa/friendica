<?php
/**
 * @copyright Copyright (C) 2010-2021, the Friendica project
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * See update_profile.php for documentation
 */

namespace Friendica\Module\Update;

use Friendica\Core\System;
use Friendica\DI;
use Friendica\Module\Conversation\Community as CommunityModule;

/**
 * Asynchronous update module for the community page
 *
 * @package Friendica\Module\Update
 */
class Community extends CommunityModule
{
	public static function rawContent(array $parameters = [])
	{
		self::parseRequest($parameters);

		$o = '';
		if (!empty($_GET['force']) || !DI::pConfig()->get(local_user(), 'system', 'no_auto_update')) {
			$o = DI::conversation()->create(self::getItems(), 'community', true, false, 'commented', local_user());
		}

		System::htmlUpdateExit($o);
	}
}
