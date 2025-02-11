<?php
/**
 * @copyright Copyright (C) 2010-2023, the Friendica project
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
 */

namespace Friendica\Object\Api\Mastodon;

use Friendica\App\BaseURL;
use Friendica\Collection\Api\Mastodon\Fields;

/**
 * Virtual entity to separate Accounts from Follow Requests.
 * In the Mastodon API they are one and the same.
 */
class FollowRequest extends Account
{
	/**
	 * Creates a follow request entity from an introduction record.
	 *
	 * The account ID is set to the Introduction ID to allow for later interaction with follow requests.
	 *
	 * @param BaseURL $baseUrl
	 * @param int     $introduction_id Introduction record id
	 * @param array   $account         entry of "account-user-view"
	 * @throws \Friendica\Network\HTTPException\InternalServerErrorException
	 */
	public function __construct(BaseURL $baseUrl, int $introduction_id, array $account)
	{
		parent::__construct($baseUrl, $account, new Fields());

		$this->id = $introduction_id;
	}
}
