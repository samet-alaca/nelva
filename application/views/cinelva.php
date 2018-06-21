<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>

<div class="container-fluid cinelva">
	<div class="flex">
		<div class="video-container">
			<div id="player" class="player">
				<div class="loader">
					<div class="lds-ripple"><div></div><div></div></div>
				</div>
				<div class="video">
					<video id="video" autoplay height="400"></video>
				</div>
				<div class="controls display-on-hover">
					<div class="logo">
						<img src="<?php echo base_url(); ?>assets/images/logo-small.png">
					</div>
					<div class="control-bar">
						<div class="control">
							<button class="control-button pause-play pause"></button>
						</div>
						<div class="control sound-container">
							<button class="control-button sound up"></button>
							<div class="sound-control all">
								<input id="video-sound" type="range" min="0" max="100" value="50" class="slider">
							</div>
						</div>
						<div class="control">
							<span class="status"><i class="offline fas fa-circle"></i> OFF</span>
							|
							<span class="count"><span id="count">1</span> <i class="fas fa-users"></i></span>
						</div>
						<div class="control right">
							<button class="control-button fs-min fullscreen"></button>
						</div>
						<div class="control right">
							<div class="quality-popup">
								<div class="quality-inner">
									<button class="quality-button active-quality">1080p</button>
									<button class="quality-button">360p</button>
								</div>
							</div>
							<button class="control-button quality" disabled></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="titan-container">
			<iframe class="titan-embed" src="https://titanembeds.com/embed/281489896563277825?lang=fr_FR&theme=DiscordDark" frameborder="0"></iframe>
		</div>
	</div>
</div>
