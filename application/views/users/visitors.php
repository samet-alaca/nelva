<div class="user-card-deck">
	<?php foreach($members->visitors as $user): ?>
		<div class="user-card-deck">
			<div class="user-info img-center">
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
		</div>
	<?php endforeach; ?>
</div>
