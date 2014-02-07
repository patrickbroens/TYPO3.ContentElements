<?php
namespace PatrickBroens\Contentelements\ViewHelpers\Tag;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Patrick Broens <patrick@patrickbroens.nl>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * View Helper which creates a header tag (h1 - hx)
 *
 * If "type" is 100, this means the header is hidden
 *
 * = Example =
 *
 * <code title="Header 1">
 * <ce:tag.hx type="1" />
 *   This is the header
 * </ce:tag.hx>
 * </code>
 *
 * <output>
 * <h1>This is the header</h1>
 * </output>
 *
 * <code title="Subheader">
 * <ce:tag.hx type="1" subheader="1" />
  *   This is the subheader
  * </ce:tag.hx>
 * </code>
 *
 * <output>
 * <h2>This is the subheader</h2>
 * </output>
 */
class HxViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper {

	/**
	 * The tag name
	 *
	 * @var string
	 */
	protected $tagName = 'h';

	/**
	 * Default type of header
	 *
	 * @var int
	 */
	protected $type = 1;

	/**
	 * Arguments initialization
	 *
	 * @return void
	 */
	public function initializeArguments() {
		$this->registerUniversalTagAttributes();
	}

	/**
	 * Render the view helper
	 *
	 * @param integer $type Type of header
	 * @param integer $defaultType Default type if no type is given
	 * @param boolean $subheader Is subheader
	 * @return string Rendered Hx
	 */
	public function render($type = 0, $defaultType = 0, $subheader = FALSE) {
		if ($type == 100) {
			return '';
		}

		$this->defineTagName($type, $defaultType, $subheader);

		$this->tag->setContent($this->renderChildren());
		$result = $this->tag->render();

		return $result;
	}

	/**
	 * Define the tag name
	 *
	 * @param $type Type of header
	 * @param $defaultType Default type if no type is given
	 * @param $subheader Is subheader
	 * @return void
	 */
	protected function defineTagName($type, $defaultType, $subheader) {
		if (!empty($type)) {
			$this->type = $type;
		} elseif(!empty($defaultType)) {
			$this->type = $defaultType;
		}

		$this->type = $subheader ? $this->type + 1 : $this->type;

		$this->tag->setTagName($this->tagName . $this->type);
	}
}