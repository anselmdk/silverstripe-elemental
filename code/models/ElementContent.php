<?php

/**
 * @package elemental
 */
class ElementContent extends BaseElement {

	private static $db = array(
		'HTML' => 'HTMLText',
		'Style' => 'Varchar'
	);

	private static $styles = array(
	);

	private static $title = "Generic Content";

	private static $description = "Blocks of text with heading, blockquote, list and paragraph styles";

	public function getCMSFields() {
		$styles = $this->config()->get('styles');

		$fields = parent::getCMSFields();

		if (count($styles) > 0) {
			$this->beforeUpdateCMSFields(function($fields) use ($styles) {
				$fields->addFieldsToTab('Root.Main', new HtmlEditorField('HTML', 'Content'));
				$fields->addFieldsToTab('Root.Main', $styles = new DropdownField('Style', 'Style', $styles));

				$styles->setEmptyString('Select a custom style..');
			});
		} else {
			$fields->removeByName('Style');
		}

		return $fields;
	}

	public function getCssStyle() {
		$styles = $this->config()->get('styles');
		$style = $this->Style;

		if(isset($styles[$style])) {
			return strtolower($styles[$style]);
		}
	}
}