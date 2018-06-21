<div class="container">
	<div class="row">
		<div class="col-md text-center">
			<?php echo anchor('/users', '<img class="img-fluid img-head" src="'.base_url().'assets/images/design/titres/utilisateurs.png"/>'); ?>
			<br>
			<hr/>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header patterned text-center">
					<h5><?php echo $user->user->username . '#' . $user->user->discriminator; ?></h5>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="float-left user-info img-center">
								<a href="/users/<?php echo $user->user->id; ?>">
									<div class="user ttt">
										<div class="user-avatar">
											<img src="<?php echo $user->user->avatar; ?>">
										</div>
										<div class="caption">
											<?php echo $user->user->username; ?>
										</div>
									</div>
								</a>
							</div>
							<div class="text-center ml80">
								<?php foreach($user->roles as $role): ?>
									<span class="badge badge-secondary" style="background-color: <?php echo $role->color; ?>"><?php echo $role->name; ?></span>
								<?php endforeach; ?>
							</div>
							<br>
							<h5 class="text-center ml80">Rangs</h5>
							<br>
							<div class="card-group text-center">
								<div class="card noshadow" data-toggle="tooltip" data-placement="top" title="Militaire">
									<div class="card-header patterned-blue" >
										<img class="img-fluid" src="<?php echo base_url() . 'assets/images/design/military.png'; ?>">
									</div>
									<div class="card-body">
										<?php echo $user->rank->m; ?>
									</div>
								</div>
								<div class="card noshadow" data-toggle="tooltip" data-placement="top" title="Economie">
									<div class="card-header patterned-blue">
										<img class="img-fluid" src="<?php echo base_url() . 'assets/images/design/economy.png'; ?>">
									</div>
									<div class="card-body">
										<?php echo $user->rank->e; ?>
									</div>
								</div>
								<div class="card noshadow" data-toggle="tooltip" data-placement="top" title="Diplomatie">
									<div class="card-header patterned-blue">
										<img class="img-fluid" src="<?php echo base_url() . 'assets/images/design/diplomacy.png'; ?>">
									</div>
									<div class="card-body">
										<?php echo $user->rank->d; ?>
									</div>
								</div>
								<div class="card noshadow" data-toggle="tooltip" data-placement="top" title="Leadership">
									<div class="card-header patterned-blue">
										<img class="img-fluid" src="<?php echo base_url() . 'assets/images/design/leadership.png'; ?>">
									</div>
									<div class="card-body">
										<?php echo $user->rank->l; ?>
									</div>
								</div>
								<div class="card noshadow" data-toggle="tooltip" data-placement="top" title="Implication">
									<div class="card-header patterned-blue">
										<img class="img-fluid" src="<?php echo base_url() . 'assets/images/design/implication.png'; ?>">
									</div>
									<div class="card-body">
										<?php echo $user->rank->i; ?>
									</div>
								</div>
							</div>
							<br>
							<div class="text-center">
								<?php $s = $user->rank->m + $user->rank->e + $user->rank->l + $user->rank->d + $user->rank->i; ?>
								<?php $r = 5; if($s<22)$r=4;if($s<18)$r=3;if($s<12)$r=2;if($s<7)$r=1; ?>
								<img class="img-fluid" src="<?php echo base_url() . 'assets/images/rubans/' . $user->rank->setting . '/' . $r . '-' . $user->rank->i . '.jpg'; ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header patterned text-center">
					<h5>Statistiques</h5>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
								<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
								<span id="period"></span>
							</div>
						</div>
						<div class="col-md-6">
							<select class="form-control iright" id="discord-chart-type">
								<option value="line" selected="true">Diagramme en ligne</option>
								<option value="bar">Diagramme en bâtons</option>
							</select>
						</div>
					</div>
					<div id="chart-container">
						<canvas id="discordChart" height="200"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br><br>
</div>
