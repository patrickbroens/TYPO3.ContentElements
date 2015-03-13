plugin.tx_contentelements {
	view {
		file = {$contentelements.view.templateRootPath}Default.html
		partialRootPath = {$contentelements.view.partialRootPath}
		layoutRootPath = {$contentelements.view.layoutRootPath}
	}
	settings {
		media {
			gallery {
				columnSpacing = {$styles.content.imgtext.colSpace}
				maximumImageWidth = {$styles.content.imgtext.maxW}
				maximumImageWidthInText = {$styles.content.imgtext.maxWInText}
				borderWidth = {$styles.content.imgtext.borderThick}
				borderPadding = {$styles.content.imgtext.borderSpace}
			}
			popup {
				bodyTag = <body style="margin:0; background:#fff;">
				wrap = <a href="javascript:close();"> | </a>
				width = {$styles.content.imgtext.linkWrap.width}
				height = {$styles.content.imgtext.linkWrap.height}
				effects = {$styles.content.imgtext.linkWrap.effects}

				JSwindow = 1
				JSwindow {
					newWindow = {$styles.content.imgtext.linkWrap.newWindow}
					if.isFalse = {$styles.content.imgtext.linkWrap.lightboxEnabled}
				}

				directImageLink = {$styles.content.imgtext.linkWrap.lightboxEnabled}

				linkParams.ATagParams.dataWrap =  class="{$styles.content.imgtext.linkWrap.lightboxCssClass}" rel="{$styles.content.imgtext.linkWrap.lightboxRelAttribute}"
			}
		}
	}
}