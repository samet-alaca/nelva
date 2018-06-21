const video = document.getElementById('video');

const mime = 'video/mp4; codecs="avc1.640028, mp4a.40.2"';
var buffer;
var socket = io('95.130.11.159:8080', { transports: ['websocket'] });
var mediaSource = new MediaSource();
video.src = URL.createObjectURL(mediaSource);
var count = 0;

if(!MediaSource.isTypeSupported(mime)) {
	alert('Codecs not supported...');
}

mediaSource.addEventListener('sourceopen', (e) => {
	buffer = mediaSource.addSourceBuffer(mime);
	buffer.mode = 'sequence';

	buffer.addEventListener('updateend', (e) => {
		//hack to get safari on mac to start playing, video.currentTime gets stuck on 0
		if(mediaSource.duration !== Number.POSITIVE_INFINITY && video.currentTime === 0 && mediaSource.duration > 0) {
			video.currentTime = mediaSource.duration - 1;
			mediaSource.duration = Number.POSITIVE_INFINITY;
		}
		if(video) {
			video.play();
		}
	})

	socket.on('count', (val) => {
		$('#count').html(val);
		$('#viewer_count').html(val);
	});

	socket.on('status', (status) => {
		switch(status) {
			case 'offline':
			$('.status').html('<i class="offline fas fa-circle"></i> OFF');
			$('.loader').css('opacity', 0);
			break;
			case 'live':
			$('.status').html('<i class="live fas fa-circle"></i> LIVE');
			break;
		}
	});

	socket.on('segment', (data) => {
		if(!buffer.updating && mediaSource.readyState == 'open') {
			count++;
			if(count > 30) {
				console.log('removing...');
				buffer.remove(1, 30);
				count = 3;
			} else {
				console.log('appending...')
				buffer.appendBuffer(new Uint8Array(data));
			}
		}
		if(count == 2) {
			$('.loader').css('opacity', 0);
		}
	});

	socket.on('message', (msg) => {
		if(msg === 'NOT_READY') {
			clearInterval(window.wait_ready);
			$('.status').html('<i class="connect fas fa-circle"></i> Waiting response...');
			$('.loader').css('opacity', 1);
			window.wait_ready = setInterval(() => {
				socket.emit('start');
			}, 1000);
		}
		if(msg === 'READY') {
			$('.status').html('<i class="live fas fa-circle"></i> LIVE');
			clearInterval(window.wait_ready);
		}
	});

	socket.on('disconnect', () => {
		$('.status').html('<i class="connect fas fa-circle"></i> Waiting connection...');
		$('.loader').css('opacity', 1);
	});
	socket.on('connect_error', () => {
		$('.status').html('<i class="connect fas fa-circle"></i> Waiting connection...');
		$('.loader').css('opacity', 1);
	});
	socket.on('connect', () => {
		$('.status').html('<i class="live fas fa-circle"></i> LIVE');
	});
}, false);

$('.pause-play').click(function() {
	if($(this).hasClass('play')) {
		$(this).removeClass('play');
		$(this).addClass('pause');
		video.play();
	} else {
		$(this).removeClass('pause');
		$(this).addClass('play');
		video.pause();
	}
});

$('.sound').click(() => {
	$('#video-sound').val(0);
	video.volume = 0;
	$('.sound').addClass('mute');
});

$('#video-sound').on('input', function() {
	video.volume = $(this).val() / 100;
	$('.sound').removeClass('up down mute');
	if(video.volume < .5) {
		if(video.volume == 0) {
			$('.sound').addClass('mute');
		} else {
			$('.sound').addClass('down');
		}
	} else {
		$('.sound').addClass('up');
	}
});

const requestFullscreen = (element) => {
	// Supports most browsers and their versions.
	var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullScreen;

	if (requestMethod) { // Native full screen.
		requestMethod.call(element);
	} else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
		var wscript = new ActiveXObject("WScript.Shell");
		if (wscript !== null) {
			wscript.SendKeys("{F11}");
		}
	}
}

const cancelFullscreen = (el) => {
	if (document.exitFullscreen) {
		document.exitFullscreen();
	} else if (document.msExitFullscreen) {
		document.msExitFullscreen();
	} else if (document.mozCancelFullScreen) {
		document.mozCancelFullScreen();
	} else if (document.webkitExitFullscreen) {
		document.webkitExitFullscreen();
	}
}

$('.fs-min').click(function() {
	if($(this).hasClass('fullscreen')) {
		$(this).removeClass('fullscreen').addClass('minimize');
		requestFullscreen(document.getElementById('player'));
		$('.player').addClass('full');
	} else {
		$(this).removeClass('minimize').addClass('fullscreen');
		cancelFullscreen(document.getElementById('player'));
	}
});

$('.quality').click(function() {
	if($(this).hasClass('qp-open')) {
		$(this).removeClass('qp-open');
		$('.quality-popup').removeClass('qp-open');
	} else {
		$(this).addClass('qp-open');
		$('.quality-popup').addClass('qp-open');
	}
});

$('.quality-button').click(function() {
	$('.quality-button').removeClass('active-quality');
	$(this).addClass('active-quality');
});

const inputFn = function () {
	var val = ($('input[type="range"]').val() - $('input[type="range"]').attr('min')) / ($('input[type="range"]').attr('max') - $('input[type="range"]').attr('min'));

	$('input[type="range"]').css('background-image',
	'-webkit-gradient(linear, left top, right top, '
	+ 'color-stop(' + val + ', #FFF), '
	+ 'color-stop(' + val + ', #333)'
	+ ')'
);
}

$('input[type="range"]').change(inputFn);
$('input[type="range"]').on('input', inputFn);
inputFn();
