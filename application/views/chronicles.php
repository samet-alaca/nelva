<style>
.canvas-container {

}
#canvas {
	width: 854px;
	height: 480px;
	margin: 0 auto;
	display: block;
}
</style>
<div class="container">
	<div class="row">
		<div class="col-md text-center">
			<img class="img-fluid" src="<?php echo base_url(); ?>assets/images/design/titres/chroniques.png" alt="Chroniques"/>
			<br><br>
			<div class="card patterned">
				<div class="card-body">
					Chroniques nelva
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<div class="canvas-container">
				<canvas id="canvas" width="854" height="480"></canvas>
			</div>
		</div>
	</div>
</div>
<script>

const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');

context.rect(0, 0, 854, 480);
context.fillStyle = '#FFFFFF';
context.fillRect(0, 0, 854, 480);
context.stroke();

</script>
