styles.content >

styles.content {
	# get content
	get = CONTENT
	get {
		table = tt_content
		select {
			orderBy = sorting
			where = colPos=0
			languageField = sys_language_uid
		}
	}

	# get content, left
	getLeft < styles.content.get
	getLeft.select.where = colPos=1

	# get content, right
	getRight < styles.content.get
	getRight.select.where = colPos=2

	# get content, margin
	getBorder < styles.content.get
	getBorder.select.where = colPos=3

	# get news
	getNews < styles.content.get
	getNews.select.pidInList = {$styles.content.getNews.newsPid}
}