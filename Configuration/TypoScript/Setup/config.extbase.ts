config.tx_extbase {
	persistence {
		classes {
			PatrickBroens\Contentelements\Overlay {
				mapping {
					tableName = pages
					columns {
						nav_title {
							mapOnProperty = navigationTitle
						}
					}
				}
			}
			PatrickBroens\Contentelements\Domain\Model\Page {
				mapping {
					tableName = pages
					columns {
						nav_title {
							mapOnProperty = navigationTitle
						}
					}
				}
			}
			PatrickBroens\Contentelements\Domain\Model\Content {
				mapping {
					tableName = tt_content
					columns {
						colPos {
							mapOnProperty = columnPosition
						}
						sectionIndex {
							mapOnProperty = showInSectionMenus
						}
					}
				}
			}
		}
	}
}