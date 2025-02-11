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
 * This file is loaded by PHPUnit before any test.
 */

use Dice\Dice;
use Friendica\DI;
use PHPUnit\Framework\TestCase;

if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
	die('Vendor path not found. Please execute "bin/composer.phar --no-dev install" on the command line in the web root.');
}

require __DIR__ . '/../vendor/autoload.php';

// Backward compatibility
if (!class_exists(TestCase::class)) {
	class_alias(\PHPUnit\Framework\TestCase::class, TestCase::class);
}

$dice = new Dice();
$dice = $dice->addRules(include  __DIR__ . '/../static/dependencies.config.php');

DI::init($dice);
