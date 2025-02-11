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

namespace Friendica\Core\Config\Model;

use Friendica\Core\Config\Capability\IManageConfigValues;
use Friendica\Core\Config\Capability\ISetConfigValuesTransactionally;
use Friendica\Core\Config\Exception\ConfigPersistenceException;
use Friendica\Core\Config\ValueObject\Cache;

/**
 * Transaction class for configurations, which sets values into a temporary buffer until "save()" is called
 */
class ConfigTransaction implements ISetConfigValuesTransactionally
{
	/** @var IManageConfigValues */
	protected $config;
	/** @var Cache */
	protected $cache;
	/** @var bool field to check if something is to save */
	protected $changedConfig = false;

	public function __construct(IManageConfigValues $config)
	{
		$this->config = $config;
		$this->cache  = clone $config->getCache();
	}

	/** {@inheritDoc} */
	public function set(string $cat, string $key, $value): ISetConfigValuesTransactionally
	{
		$this->cache->set($cat, $key, $value, Cache::SOURCE_DATA);
		$this->changedConfig = true;

		return $this;
	}


	/** {@inheritDoc} */
	public function delete(string $cat, string $key): ISetConfigValuesTransactionally
	{
		$this->cache->delete($cat, $key);
		$this->changedConfig = true;

		return $this;
	}

	/** {@inheritDoc} */
	public function commit(): void
	{
		// If nothing changed, just do nothing :)
		if (!$this->changedConfig) {
			return;
		}

		try {
			$this->config->setCacheAndSave($this->cache);
			$this->cache = clone $this->config->getCache();
		} catch (\Exception $e) {
			throw new ConfigPersistenceException('Cannot save config', $e);
		}
	}
}
