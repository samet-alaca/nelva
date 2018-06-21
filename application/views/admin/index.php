<div class="container">
	<br>
	<div class="row">
		<div class="col-md-12">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="bestiaire-tab" data-toggle="tab" href="#bestiaire" role="tab" aria-controls="bestiaire" aria-selected="true">Bestiaire</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="stats-tab" data-toggle="tab" href="#stats" role="tab" aria-controls="stats" aria-selected="false">Stats</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="notify-tab" data-toggle="tab" href="#notify" role="tab" aria-controls="notify" aria-selected="false">Notify</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="members-tab" data-toggle="tab" href="#members" role="tab" aria-controls="members" aria-selected="false">Membres</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="tasks-tab" data-toggle="tab" href="#tasks" role="tab" aria-controls="tasks" aria-selected="false">Tâches</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="bestiaire" role="tabpanel" aria-labelledby="bestiaire">
					<div class="card noshadow">
						<div class="card-header patterned text-center">
							<h5>Bestiaire</h5>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label for="bestiaire-pseudo">Pseudo</label>
								<input class="form-control" type="text" name="pseudo" placeholder="Pseudo">
							</div>
							<div class="form-group">
								<label for="bestiaire-message">Message</label>
								<textarea class="form-control" name="message"></textarea>
							</div>
							<button class="btn btn-primary addBestiaire">Ajouter</button>
							<hr class="classic-hr">
							<div class="form-group"id="searchfield">
								<input class="form-control" id="autocomplete" placeholder="Pseudo">
							</div>
							<div class="card noshadow" id="content">
								<div class="card-header patterned" id="pseudo"></div>
								<div class="card-body" id="messages"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="stats" role="tabpanel" aria-labelledby="stats">
					<div class="card noshadow">
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
							<div class="row">
								<div class="col-md-12">
									<div id="chart-container">
										<canvas id="discordChart" height="200"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="notify" role="tabpanel" aria-labelledby="notify">
					<div class="card noshadow">
						<div class="card-header patterned text-center">
							<h5>Notify</h5>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="notify-role">Rôle</label>
										<select class="form-control" name="notify-role" id="notify-role">
											<?php foreach($roles as $role): ?>
												<option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="form-group">
										<label for="notify-message">Message</label>
										<textarea class="form-control" name="notify-message" id="notify-message"></textarea>
									</div>
									<button class="btn btn-primary postNotify">Ajouter</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="members" role="tabpanel" aria-labelledby="members">
					<div class="card noshadow">
						<div class="card-header patterned text-center">
							<h5>Membres</h5>
						</div>
						<div class="card-body">
							<table class="table" id="testTab">
								<thead>
									<tr>
										<th scope="col">#</th>
										<th scope="col">Pseudo</th>
										<th scope="col">Activité</th>
										<th scope="col">Rang</th>
										<th scope="col">Role</th>
										<th scope="col">Rejoint en</th>
										<th scope="col">Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 0; ?>
									<?php foreach($members->admins as $user): ?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $user->user->username; ?></td>
											<td>
												<div class="progress" data-toggle="tooltip" data-placement="top" title="<?php echo $user->activity; ?>%">
													<div class="progress-bar" role="progressbar" style="width: <?php echo $user->activity; ?>%" aria-valuenow="<?php echo $user->activity; ?>" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</td>

											<td><?php echo $user->rank; ?></td>
											<td><?php echo $user->formatted_roles; ?></td>
											<td><?php echo $user->joined_at; ?></td>
											<td><?php echo ""; ?></td>
										</tr>
										<?php $i++; ?>
									<?php endforeach; ?>
									<?php foreach($members->members as $user): ?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $user->user->username; ?></td>
											<td>
												<div class="progress" data-toggle="tooltip" data-placement="top" title="<?php echo $user->activity; ?>%">
													<div class="progress-bar" role="progressbar" style="width: <?php echo $user->activity; ?>%" aria-valuenow="<?php echo $user->activity; ?>" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</td>

											<td><?php echo $user->rank; ?></td>
											<td><?php echo $user->formatted_roles; ?></td>
											<td><?php echo $user->joined_at; ?></td>
											<td><?php echo ""; ?></td>
										</tr>
										<?php $i++; ?>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane fade" id="tasks" role="tabpanel" aria-labelledby="tasks">

	</div>
</div>
