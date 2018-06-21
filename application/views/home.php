<div class="container">
	<div class="row">
		<div class="col-md text-center">
			<img class="img-fluid" src="<?php echo base_url(); ?>assets/images/logo-fit.png" alt="Nelva"/>
			<div class="card patterned">
				<div class="card-body">
					<?php echo $this->lang->line('home_main_description'); ?>
				</div>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md text-center">
			<img class="img-fluid" src="<?php echo base_url(); ?>assets/images/design/titres/valeurs.png" alt="Valeurs"/>
		</div>
	</div>
	<div class="row">
		<div class="col-sm">
			<div class="card-deck">
				<div class="card">
					<div class="card-header patterned-gold text-center">
						<h5><?php echo $this->lang->line('home_education_title'); ?></h5>
					</div>
					<div class="card-body text-sm text-justify">
						<p><?php echo $this->lang->line('home_education_text'); ?></p>
					</div>
				</div>
				<div class="card">
					<div class="card-header patterned text-center">
						<h5><?php echo $this->lang->line('home_bravery_title'); ?></h5>
					</div>
					<div class="card-body text-sm text-justify">
						<p><?php echo $this->lang->line('home_bravery_text'); ?></p>
					</div>
				</div>
				<div class="card">
					<div class="card-header patterned-blue text-center">
						<h5><?php echo $this->lang->line('home_kindness_title'); ?></h5>
					</div>
					<div class="card-body text-sm text-justify">
						<p><?php echo $this->lang->line('home_kindness_text'); ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md text-center">
			<?php echo anchor('/users', '<img class="img-fluid img-head" src="'.base_url().'assets/images/design/titres/equipe.png"/>'); ?>
		</div>
	</div>
</div>
