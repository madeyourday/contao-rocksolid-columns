<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\RockSolidColumns\Model;

use Contao\ContentModel;
use Contao\Database\Result;

/**
 * Dummy columns model
 *
 * @author Martin Auswöger <martin@madeyourday.net>
 */
class DummyColumnsModel extends ContentModel
{
	/**
	 * {@inheritdoc}
	 */
	public function __construct(Result $objResult = null, $data = array())
	{
		$this->arrModified = array();
		$this->setRow($data);
	}
}
