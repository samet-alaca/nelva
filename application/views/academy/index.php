<div class="container">
	<div class="row">
		<div class="col-md">
			<div class="text-center header">
				<?php echo anchor('/academy', '<img class="img-fluid img-head" src="'.base_url().'assets/images/design/titres/academie.png"/>'); ?>
				<br><br>
				<div class="card patterned">
					<div class="card-body">
						<?php echo $this->lang->line('academy_welcome'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br><br>
	<div class="row">
		<div class="col-md-3">
			<a href="/academy/military">
				<div class="card card-default academy-category">
					<div class="card-header patterned text-center"><img src="<?php echo base_url(); ?>assets/images/design/academie/militaire-or.png" class="img-fluid" ></div>
					<div class="card-body">
						<img class="img-fluid" src="<?php echo base_url(); ?>assets/images/academie/militaire.jpg"/>
					</div>
				</div>
			</a>
		</div>

		<div class="col-md-3">
			<a href="/academy/economy">
				<div class="card card-default academy-category">
					<div class="card-header patterned text-center"><img src="<?php echo base_url(); ?>assets/images/design/academie/economie-or.png" class="img-fluid" ></div>
					<div class="card-body">
						<img class="img-fluid" src="<?php echo base_url(); ?>assets/images/academie/economie.jpg"/>
					</div>
				</div>
			</a>
		</div>

		<div class="col-md-3">
			<a href="/academy/diplomacy">
				<div class="card card-default academy-category">
					<div class="card-header patterned text-center"><img src="<?php echo base_url(); ?>assets/images/design/academie/diplomatie-or.png" class="img-fluid" ></div>
					<div class="card-body">
						<img class="img-fluid" src="<?php echo base_url(); ?>assets/images/academie/economie.jpg"/>
					</div>
				</div>
			</a>
		</div>

		<div class="col-md-3">
			<a href="/academy/leadership">
				<div class="card card-default academy-category">
					<div class="card-header patterned text-center"><img src="<?php echo base_url(); ?>assets/images/design/academie/leadership-or.png" class="img-fluid" ></div>
					<div class="card-body">
						<img class="img-fluid" src="<?php echo base_url(); ?>assets/images/academie/leadership.jpg"/>
					</div>
				</div>
			</a>
		</div>
	</div>
</div>
