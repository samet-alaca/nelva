<div class="container">
	<div class="row">
		<div class="col-md text-center">
			<?php echo anchor('/nexus', '<img class="img-fluid img-head" src="'.base_url().'assets/images/design/titres/nexus.png"/>'); ?>
			<br>
			<hr/>
		</div>
	</div>
	<div class="row">
		<div class="col-md">
			<br>
			<div class="card patterned">
				<?php if(isset($errors)): ?>
					<br>
					<?php foreach($errors as $error): ?>
						<div class="alert alert-danger"><?php echo $error; ?></div>
					<?php endforeach; ?>
				<?php elseif(isset($upload_errors)): ?>
					<br>
					<?php foreach($upload_errors as $error): ?>
						<div class="alert alert-danger"><?php echo $error; ?></div>
					<?php endforeach; ?>
				<?php elseif($this->session->logged && $this->session->isMember): ?>
					<div class="card-body">
						<form enctype="multipart/form-data" method="post" action="">
							<div class="form-group">
								<label for="title"><?php echo $this->lang->line('nexus_create_title'); ?></label>
								<input type="text" class="form-control" name="title" placeholder="Titre du document">
							</div>
							<div class="form-group">
								<label for="description"><?php echo $this->lang->line('nexus_create_description'); ?></label>
								<textarea class="form-control" name="description" rows="2"></textarea>
							</div>
							<div class="form-group">
								<label for="image"><?php echo $this->lang->line('nexus_create_image'); ?></label>
								<input name="userfile" type="file" class="form-control-file" id="file">
								<input type="hidden" name="extension" id="ext">
							</div>
							<div class="form-group">
								<label for="category"><?php echo $this->lang->line('nexus_create_category'); ?></label>
								<select class="form-control" id="category" name="category">
									<?php foreach($categories as $category): ?>
										<option value='<?php echo $category['tag']; ?>'><?php echo $category['pretty']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="hidden" id="courseWrap">
								<div class="form-group">
									<label for="courseType"><?php echo $this->lang->line('nexus_create_courseType'); ?></label>
									<select class="form-control" id="courseType" name="courseType">
										<option value="military"><?php echo $this->lang->line('nexus_create_courseMilitary'); ?></option>
										<option value="diplomacy"><?php echo $this->lang->line('nexus_create_courseDiplomacy'); ?></option>
										<option value="economy"><?php echo $this->lang->line('nexus_create_courseEconomy'); ?></option>
										<option value="leadership"><?php echo $this->lang->line('nexus_create_courseLeadership'); ?></option>
									</select>
								</div>
								<div class="form-group">
									<label for="courseRank"><?php echo $this->lang->line('nexus_create_courseRank'); ?></label>
									<select class="form-control" id="courseRank" name="courseRank">
										<option value="5">5 -> 4</option>
										<option value="4">4 -> 3</option>
										<option value="3">3 -> 2</option>
										<option value="2">2 -> 1</option>
									</select>
								</div>
								<div class="form-group">
									<label for="courseOrder"><?php echo $this->lang->line('nexus_create_courseOrder'); ?></label>
									<select class="form-control" id="courseOrder" name="courseOrder">
									</select>
								</div>
							</div>
							<div class="form-group">
								<textarea class="txt-ckedit" id="editor" name="content"></textarea>
							</div>
							<button class="btn btn-primary float-right" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang->line('nexus_create_submit'); ?></button>
						</form>
					</div>
				<?php else: ?>
					<div class="card-body">
						<?php echo $this->lang->line('nexus_unauthorized'); ?>
					</div>
				<?php endif; ?>
			</div>
			<br><br>
		</div>
	</div>
</div>
