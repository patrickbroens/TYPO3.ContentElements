# ***************************************************************************************
# Page TSconfig for "contentelements"
#
# Removes obsolete type values and fields from "Content Element" table "tt_content"
# ***************************************************************************************

TCEFORM {
	tt_content {
			# Remove obsolete fields. These do not work in "Content Elements"
		image_compression.disabled = 1
		image_effects.disabled = 1
		image_frames.disabled = 1
		image_noRows.disabled = 1
		imagecaption_position.disabled = 1
		section_frame.disabled = 1
		spaceAfter.disabled = 1
		spaceBefore.disabled = 1
		table_bgColor.disabled = 1
		table_border.disabled = 1
		table_cellspacing.disabled = 1
		table_cellpadding.disabled = 1

			# Remove CTypes which are rendered by CType "media"
		CType.removeItems := addToList(swfobject,qtobject,multimedia)

			# Remove unused positioning types in CType "image"
		imageorient {
			types {
				image {
					removeItems := addToList(8,9,10,17,18,25,26)
				}
			}
		}

			# Remove fields which are not in use by default, more action has to be done to make these work
		categories.disabled = 1
		fe_group.disabled = 1
		layout.disabled = 1

			# Change labels
		header_layout {
			altLabels {
				1 = Heading 1
				2 = Heading 2
				3 = Heading 3
				4 = Heading 4
				5 = Heading 5
			}
		}
	}
}