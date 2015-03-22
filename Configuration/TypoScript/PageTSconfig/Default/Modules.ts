# *************************************************************************
# Removes obsolete type values and fields from "New Content Element Wizard"
# *************************************************************************

mod.wizards.newContentElement {
	wizardItems {
		common {
			elements {
				text >
				textpic >
				textmedia {
					icon = gfx/c_wiz/text_image_right.gif
					title = LLL:EXT:contentelements/Resources/Private/Language/NewContentElementWizard.xlf:common_textMedia_title
					description = LLL:EXT:contentelements/Resources/Private/Language/NewContentElementWizard.xlf:common_textMedia_description
					tt_content_defValues {
						CType = textmedia
						imageorient = 17
					}
				}
				image >
			}
			show = header,textmedia,bullets,table
		}
	}
}