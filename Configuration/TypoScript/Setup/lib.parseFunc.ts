# Creates persistent ParseFunc setup for non-HTML content. This is recommended to use (as a reference!)
lib.parseFunc {
	makelinks = 1
	makelinks {
		http {
			keep = {$styles.content.links.keep}
			extTarget < lib.parseTarget
			extTarget =
			extTarget.override = {$styles.content.links.extTarget}
		}
		mailto {
			keep = path
		}
	}
	tags {
		link = TEXT
		link {
			current = 1
			typolink {
				parameter.data = parameters : allParams
				extTarget < lib.parseTarget
				extTarget =
				extTarget.override = {$styles.content.links.extTarget}
				target < lib.parseTarget
				target =
				target.override = {$styles.content.links.target}
			}
			parseFunc.constants = 1
		}
	}
	allowTags = {$styles.content.allowTags}
	denyTags = *
	sword = <span class="csc-sword">|</span>
	constants = 1
	nonTypoTagStdWrap {
		HTMLparser = 1
		HTMLparser {
			keepNonMatchedTags = 1
			htmlSpecialChars = 2
		}
	}
}

# good old parsefunc in "styles.content.parseFunc" is created for backwards compatibility. Don't use it, just ignore.
styles.content.parseFunc < lib.parseFunc