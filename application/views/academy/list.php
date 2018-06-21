<div class="container">
	<div class="row">
		<div class="col-md text-center">
			<?php echo anchor('/academy', '<img class="img-fluid img-head" src="'.base_url().'assets/images/design/titres/academie.png"/>'); ?>
			<br><br>
			<div class="card patterned">
				<div class="card-body">
					<?php echo $this->lang->line('academy_welcome'); ?>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<br>
	<?php if($courses): ?>
		<ul class="nexus-items list-unstyled" id="grid">
			<?php foreach($courses as $document): ?>
				<li class="col-md-4 col-sm-4 col-xs-6 nexus-item academy-item" data-groups='<?php echo $document['tags']; ?>' data-date-created="<?php echo $document['created_at']; ?>" data-title="<?php echo $document['title']; ?>">
					<a href="cours/<?php echo $document['slug']; ?>" class="nexus-doc-wrap">
						<div class="card text-center patterned" style="width: 21.87rem;">
							<img class="card-img-top squared" src="<?php echo base_url(); ?>uploads/nexus/images/<?php echo $document['image']; ?>" alt="Card image cap">
							<div class="card-body">
								<h6 class="card-title truncate" data-toggle="tooltip" data-placement="top" title="<?php echo $document['title']; ?>"><?php echo $document['title']; ?></h6>
								<p class="card-text truncate" data-toggle="tooltip" data-placement="top" title="<?php echo $document['description']; ?>">&nbsp;<?php echo $document['description']; ?></p>
							</div>
						</div>
					</a>
				</li>
			<?php endforeach; ?>
			<li class="col-md-4 col-sm-4 col-xs-6 shuffle_sizer"></li>
		</ul>
	<?php else: ?>
		<div class="card patterned">
			<div class="card-body">
				<?php echo $this->lang->line('academy_empty'); ?>
			</div>
		</div>
	<?php endif; ?>
</div>
