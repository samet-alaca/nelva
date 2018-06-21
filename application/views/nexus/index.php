<div class="container">
	<div class="row">
		<div class="col-md text-center">
			<img class="img-fluid" src="<?php echo base_url(); ?>assets/images/design/titres/nexus.png" alt="Nexus"/>
			<br><br>
			<div class="card patterned">
				<div class="card-body">
					<?php echo $this->lang->line('nexus_main_description'); ?>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<?php if(!isset($this->session->isAdmin) || $this->session->isAdmin): ?>
		<br>
		<?php echo anchor('nexus/create', '<i class="fas fa-plus"></i> ' . $this->lang->line('nexus_new_document'), 'class="btn btn-primary"'); ?>
		<br>
	<?php endif; ?>
	<br>
	<div class="input-group">
		<input type="text" class="form-control js-shuffle-search" placeholder="Cherchez un document"/>
	</div>
	<br>
	<div class="nexus-sorting filters-group">
		<div class="btn-group filter-options">
			<button class="fo-btn btn btn-primary active" data-group="all">Tout</button>
			<?php foreach($categories as $category): ?>
				<button class="fo-btn btn btn-primary" data-group="<?php echo json_decode($category['tag'])[0]; ?>"><?php echo $category['pretty']; ?></button>
			<?php endforeach; ?>
		</div>
	</div>

	<ul class="nexus-items list-unstyled" id="grid">
		<?php foreach($documents as $document): ?>
			<li data-toggle="tooltip" data-placement="top" title="<?php echo $document['description']; ?>" class="col-md-4 col-sm-4 col-xs-6 nexus-item" data-groups='<?php echo $document['tags']; ?>' data-date-created="<?php echo $document['created_at']; ?>" data-title="<?php echo $document['title']; ?>">
				<a href="nexus/<?php echo $document['slug']; ?>" class="nexus-doc-wrap">
					<div class="card text-center patterned" style="width: 21.87rem;">
						<br>
						<img class="card-img-top squared img-thumbnail" src="<?php echo base_url(); ?>uploads/nexus/images/<?php echo $document['image']; ?>" alt="Card image cap">
						<div class="card-body">
							<h6 class="card-title truncate" data-toggle="tooltip" data-placement="top" title="<?php echo $document['title']; ?>"><?php echo $document['title']; ?></h6>

						</div>
					</div>
				</a>
			</li>
		<?php endforeach; ?>
		<li class="col-md-4 col-sm-4 col-xs-6 shuffle_sizer"></li>
	</ul>
</div>
