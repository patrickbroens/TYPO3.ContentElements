lib.stdContent >
lib.stdContent = FLUIDTEMPLATE
lib.stdContent {
	file = {$contentelements.view.templateRootPath}Default.html
	partialRootPath = {$contentelements.view.partialRootPath}
	layoutRootPath = {$contentelements.view.layoutRootPath}

	settings {
		defaultHeaderType = {$content.defaultHeaderType}
		shortcutTables = {$content.shortcut.tables}
	}
}