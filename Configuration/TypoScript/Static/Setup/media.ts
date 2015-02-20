media {
	quicktime = QTOBJECT
	quicktime {
		file =
		width =
		height =

		flexParams.field = pi_flexform

		layout = ###QTOBJECT###

		video {
			player = {$styles.content.media.videoPlayer}

			defaultWidth  = {$styles.content.media.defaultVideoWidth}
			defaultHeight  = {$styles.content.media.defaultVideoHeight}

			default {
				params.quality = high
				params.menu = false
				params.allowScriptAccess = sameDomain
				params.allowFullScreen = true
			}
			mapping {
				flashvars {
					oldKey = newKey
				}
				params {
					oldKey = newKey
				}
			}
			attributes {
				params {
					oldKey = newKey
				}
			}
		}

		audio {
			player = {$styles.content.media.audioPlayer}

			defaultWidth = {$styles.content.media.defaultAudioWidth}
			defaultHeight = {$styles.content.media.defaultAudioHeight}

			default {
				params.quality = high
				params.allowScriptAccess = sameDomain
				params.menu = false
			}
			mapping {
				flashvars.file = soundFile
			}
		}
	}
	swf = SWFOBJECT
	swf {
		file =
		width =
		height =

		flexParams.field = pi_flexform

		layout = ###SWFOBJECT###

		video {
			player = {$styles.content.media.videoPlayer}

			defaultWidth  = {$styles.content.media.defaultVideoWidth}
			defaultHeight  = {$styles.content.media.defaultVideoHeight}

			default {
				params.quality = high
				params.menu = false
				params.allowScriptAccess = sameDomain
				params.allowFullScreen = true
			}
			mapping {
				flashvars {
					oldKey = newKey
				}
				params {
					oldKey = newKey
				}
			}
			attributes {
				params {
					oldKey = newKey
				}
			}
		}

		audio {
			player = {$styles.content.media.audioPlayer}

			defaultWidth = {$styles.content.media.defaultAudioWidth}
			defaultHeight = {$styles.content.media.defaultAudioHeight}

			default {
				params.quality = high
				params.allowScriptAccess = sameDomain
				params.menu = false
			}
			mapping {
				flashvars.file = soundFile
			}
		}
	}
	default = MEDIA
	default {
		flexParams.field = pi_flexform
		alternativeContent = TEXT
		alternativeContent {
			field = bodytext
			required = 1
			parseFunc =< lib.parseFunc_RTE
		}

		type = video
		renderType = auto
		allowEmptyUrl = 0
		forcePlayer = 1

		fileExtHandler {
			default = MEDIA
			avi = MEDIA
			asf = MEDIA
			class = MEDIA
			wmv = MEDIA
			mp3 = SWF
			mp4 = SWF
			m4v = SWF
			swa = SWF
			flv = SWF
			swf = SWF
			mov = QT
			m4v = QT
			m4a = QT
		}

		mimeConf.swfobject < media.swf
		mimeConf.qtobject < media.quicktime
		mimeConf.flowplayer < media.swf
		mimeConf.flowplayer.audio.player = {$styles.content.media.flowPlayer}
		mimeConf.flowplayer.video.player = {$styles.content.media.flowPlayer}
	}
}