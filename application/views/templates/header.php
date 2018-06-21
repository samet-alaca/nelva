<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo $page->description; ?>">

	<title><?php echo $page->title; ?></title>

	<link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.png"/>

	<?php if(isset($page->links)): ?>
		<?php foreach($page->links as $link): ?>
			<link rel="stylesheet" type="text/css" href="<?php echo $link; ?>"/>
		<?php endforeach; ?>
	<?php endif; ?>

	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.6/cookieconsent.min.css"/>
	<link rel="stylesheet" type="text/css" href="//use.fontawesome.com/releases/v5.0.8/css/all.css"/>
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css"/>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto"/>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/alertifyjs/1.10.0/css/alertify.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/style/app.css"/>

	<script defer type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script defer type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script defer type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script defer type="text/javascript" src="//cdn.jsdelivr.net/alertifyjs/1.10.0/alertify.min.js"></script>
	<script defer type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.6/cookieconsent.min.js"></script>

	<?php if(isset($page->scripts)): ?>
		<?php foreach($page->scripts as $script): ?>
			<script defer type="text/javascript" src="<?php echo $script; ?>"></script>
		<?php endforeach; ?>
	<?php endif; ?>

	<script defer type="text/javascript" src="<?php echo base_url(); ?>assets/js/app.js"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="<?php echo base_url(); ?>"><img class="img-fluid small" src="<?php echo base_url(); ?>assets/images/logo-small.png"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item <?php echo ($this->uri->segment(1) == '') ? 'active"' : '"';  ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>"><?php echo $this->lang->line('template_home'); ?> <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item <?php echo ($this->uri->segment(1) == 'landing') ? 'active"' : '"';  ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>landing"><?php echo $this->lang->line('template_landing'); ?></a>
				</li>
				<li class="nav-item <?php echo ($this->uri->segment(1) == 'users') ? 'active"' : '"';  ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>users"><?php echo $this->lang->line('template_users'); ?></a>
				</li>
				<li class="nav-item <?php echo ($this->uri->segment(1) == 'academy') ? 'active"' : '"';  ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>academy"><?php echo $this->lang->line('template_academy'); ?></a>
				</li>
				<li class="nav-item <?php echo ($this->uri->segment(1) == 'nexus') ? 'active"' : '"';  ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>nexus"><?php echo $this->lang->line('template_nexus'); ?></a>
				</li>
				<li class="nav-item <?php echo ($this->uri->segment(1) == 'cinelva') ? 'active"' : '"';  ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>cinelva"><?php echo $this->lang->line('template_cinelva') . ' <span id="viewer_count"></span>'; ?></a>
				</li>

				<?php if(isset($this->session->isAdmin) && $this->session->isAdmin): ?>
				<li class="nav-item <?php echo ($this->uri->segment(1) == 'admin') ? 'active"' : '"';  ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>admin"><?php echo $this->lang->line('template_admin'); ?></a>
				</li>
				<?php endif; ?>

				<li class="nav-item <?php echo ($this->uri->segment(1) == 'chronicles') ? 'active"' : '"';  ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>chronicles"><?php echo $this->lang->line('template_chronicles'); ?></a>
				</li>
			</ul>
			<form class="form-inline my-2 my-lg-0">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="flag-icon flag-icon-<?php echo $this->session->lang; ?>"></span>
						</a>
						<div class="dropdown-menu text-center" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" data-lang="gb" href=""><span class="flag-icon flag-icon-gb"></span></a>
							<a class="dropdown-item" data-lang="fr" href=""><span class="flag-icon flag-icon-fr"></span></a>
						</div>
					</li>
				</ul>
				<?php if(isset($this->session->user)): ?>
					<a href="<?php echo base_url(); ?>users/<?php echo $this->session->user->id; ?>"><img src="https://cdn.discordapp.com/avatars/<?php echo $this->session->user->id . '/' . $this->session->user->avatar . '.png' ?>" class="rounded user-avatar mx-auto d-block" alt=""></a>
				<?php else: ?>
					<a class="btn btn-outline-success my-2 my-sm-0" href="<?php echo $authUrl; ?>"><?php echo $this->lang->line('template_signin'); ?></a>
				<?php endif; ?>
			</form>
		</div>
	</nav>
