# Creates persistent ParseFunc setup for RTE content (which is mainly HTML) based on the "ts_css" transformation.
lib.parseFunc_RTE < lib.parseFunc
lib.parseFunc_RTE {
	//  makelinks >
	# Processing <table> and <blockquote> blocks separately
	externalBlocks = article, aside, blockquote, div, dd, dl, footer, header, nav, ol, section, table, ul
	externalBlocks {
		# The blockquote content is passed into parseFunc again...
		blockquote {
			stripNL = 1
			callRecursive = 1
			callRecursive {
				tagStdWrap {
					HTMLparser = 1
					HTMLparser.tags.blockquote.overrideAttribs = style="margin-bottom:0;margin-top:0;"
				}
			}
		}

		ol {
			stripNL = 1
			stdWrap.parseFunc = < lib.parseFunc
		}

		ul {
			stripNL = 1
			stdWrap.parseFunc = < lib.parseFunc
		}

		table {
			stripNL = 1
			stdWrap {
				HTMLparser = 1
				HTMLparser {
					tags.table.fixAttrib.class {
						default = contenttable
						always = 1
						list = contenttable
					}
					keepNonMatchedTags = 1
				}
			}
			HTMLtableCells = 1
			HTMLtableCells {
				# Recursive call to self but without wrapping non-wrapped cell content
				default.stdWrap {
					parseFunc = < lib.parseFunc_RTE
					parseFunc.nonTypoTagStdWrap.encapsLines.nonWrappedTag =
				}
				addChr10BetweenParagraphs = 1
			}
		}

		div {
			stripNL = 1
			callRecursive = 1
		}

		article < .div
		aside < .div
		footer < .div
		header < .div
		nav < .div
		section < .div
		dl < .div
		dd < .div
	}
	nonTypoTagStdWrap {
		encapsLines {
			encapsTagList = p,pre,h1,h2,h3,h4,h5,h6,hr,dt
			remapTag.DIV = P
			nonWrappedTag = P
			innerStdWrap_all.ifBlank = &nbsp;
			addAttributes {
				P {
					class = bodytext
					class.setOnly = blank
				}
			}
		}
	}
	nonTypoTagStdWrap {
		HTMLparser = 1
		HTMLparser {
			keepNonMatchedTags = 1
			htmlSpecialChars = 2
		}
	}
}