<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\Contao\Form;

use MadeYourDay\Contao\Model\DummyColumnsModel;
use MadeYourDay\Contao\Columns;

/**
 * Custom form widget
 *
 * @author Martin Auswöger <martin@madeyourday.net>
 */
class ColumnsWidget extends \Widget
{
	/**
	 * @var string Template
	 */
	protected $strTemplate = 'form_rs_columns_plain';

	/**
	 * @var \ContentElement
	 */
	private $contentElement;

	/**
	 * {@inheritdoc}
	 */
	public function __construct($data = null)
	{
		if (!empty($data['class'])) {
			$data['cssID'] = serialize(array('', $data['class']));
		}

		$class = \ContentElement::findClass($data['type']);

		$this->contentElement = new $class(new DummyColumnsModel(null, $data));

		parent::__construct($data);
	}

	/**
	 * {@inheritdoc}
	 */
	public function generate()
	{
		return $this->contentElement->generate();
	}

	/**
	 * Do not validate
	 */
	public function validate()
	{
		return;
	}
}
