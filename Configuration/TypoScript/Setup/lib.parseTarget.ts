# Creates a condition for targets. Not allowed in XHTML except for xhtml frames DTD
lib.parseTarget {
	override =
	override.if {
		isTrue.data = TSFE:dtdAllowsFrames
	}
}