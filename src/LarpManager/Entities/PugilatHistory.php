<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2017-05-02 11:53:35.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use LarpManager\Entities\BasePugilatHistory;

/**
 * LarpManager\Entities\PugilatHistory
 *
 * @Entity()
 */
class PugilatHistory extends BasePugilatHistory
{
	public function __construct()
	{
		$this->setDate(new \Datetime('NOW'));
	}
}