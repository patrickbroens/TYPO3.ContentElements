# ******************************************************************************************
# Page TSconfig for "contentelements"
#
# Removes most of the editing fields for beginners from "Content Element" table "tt_content"
# ******************************************************************************************

TCEFORM {
	tt_content {
			# Header
		date.disabled = 1
		header_link.disabled = 1
		header_position.disabled = 1
		subheader.disabled = 1

			# RTE
		rte_enabled.disabled = 1

			# Images
		imageborder.disabled = 1
		imageheight.disabled = 1
		imagewidth.disabled = 1

			# Language
		sys_language_uid.disabled = 1

			# Visibility
		endtime.disabled = 1
		linkToTop.disabled = 1
		sectionIndex.disabled = 1
		starttime.disabled = 1

			# File Links
		filelink_sorting.disabled = 1
		target.disabled = 1

			# Menu
		accessibility_bypass.disabled = 1
		accessibility_bypass_text.disabled = 1
		accessibility_title.disabled = 1

			# Tables
		cols.disabled = 1
		table_caption.disabled = 1
		table_delimiter.disabled = 1
		table_enclosure.disabled = 1
		table_header_position.disabled = 1
		table_tfoot.disabled = 1
	}
}