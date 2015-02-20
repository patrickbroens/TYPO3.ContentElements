plugin.tx_contentelements {
	view {
		file = {$contentelements.view.templateRootPath}Default.html
		partialRootPath = {$contentelements.view.partialRootPath}
		layoutRootPath = {$contentelements.view.layoutRootPath}
	}
	settings {
		columnSpacing = {$styles.content.imgtext.colSpace}
		rowSpacing = {$styles.content.imgtext.rowSpace}
		maximumImageWidth = {$styles.content.imgtext.maxW}
		maximumImageWidthInText = {$styles.content.imgtext.maxWInText}
		textMargin = {$styles.content.imgtext.textMargin}
		borderWidth = {$styles.content.imgtext.borderThick}
		borderPadding = {$styles.content.imgtext.borderSpace}
	}
}