<div class="container">
	<div class="row">
		<div class="col-md text-center">
			<?php echo anchor('/academy', '<img class="img-fluid img-head" src="'.base_url().'assets/images/design/titres/academie.png"/>'); ?>
			<br>
		</div>
	</div>

	<?php if(isset($document)): ?>

		<div class="row">
			<div class="col-md">
				<br>
				<h3 class="text-center"><?php echo $document->title; ?></h3>

				<?php if($this->session->logged): ?>
					<div class="float-right">
						<a class="btn btn-primary" href="<?php echo base_url() . 'nexus/' . $slug; ?>"><i class="fas fa-external-link-alt"></i> Source</a>
					</div>
					<br/><br/>
				<?php endif; ?>
			</div>
		</div>

		<div class="post-container patterned">
			<div class="row">
				<div class="post-description">
					<div class="desc-img">
						<div class="user-info  img-center">
							<?php if($document->author): ?>
								<?php echo anchor('users/' . $document->author->user->id, '<div class="user ttt">' . '<div class="user-avatar">'. '<img src="'.$document->author->user->avatar.'"/>'.'</div>'.'<div class="caption">'. $document->author->user->username. '</div>'. '</div>'); ?>
							<?php else: ?>
								<a href="#">
									<div class="user ttt">
										<div class="user-avatar">
											<img src="<?php echo base_url(); ?>assets/images/design/error_user.png">
										</div>
										<div class="caption">Not found</div>
									</div>
								</a>
							<?php endif; ?>
						</div>
					</div>

					<div class="desc-text">
						<h4><small><?php echo $document->title; ?></small></h4>
						<?php if($document->author): ?>
							<?php echo $this->lang->line('nexus_by') . ' ' . anchor('users/' . $document->author->user->id, $document->author->user->username); ?>
						<?php else: ?>
							<?php echo $this->lang->line('nexus_by') . ' no one' ?>
						<?php endif; ?> -
						<small><i class="far fa-clock"></i> <?php echo $document->created_at; ?></small>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm">
					<hr class="classic-hr"/>
					<div class="post-content document-content"><?php echo $document->content; ?></div>
					<?php if($document->edited_at): ?>
						<hr class="classic-hr"/>
						<em>Edité <small><i class="far fa-clock"></i> <?php echo $document->edited_at; ?></small></em>
					<?php endif; ?>
					<hr class="classic-hr"/>
					<div class="text-center">
						<?php $s = $document->author->rank->m + $document->author->rank->e + $document->author->rank->l + $document->author->rank->d + $document->author->rank->i; ?>
						<?php $r = 5; if($s<22)$r=4;if($s<18)$r=3;if($s<12)$r=2;if($s<7)$r=1; ?>
						<img class="img-fluid" src="<?php echo base_url() . 'assets/images/rubans/' . $document->author->rank->setting . '/' . $r . '-' . $document->author->rank->i . '.jpg'; ?>">
					</div>
				</div>
			</div>
		</div>
		<br/>
	<?php else: ?>
		<div class="card patterned">
			<div class="card-body">
				<i class="fa fa-frown"></i>
				<?php echo $this->lang->line('nexus_empty_doc'); ?>
			</div>
		</div>
	<?php endif; ?>
</div>
