<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container-fluid">
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" aria-current="page" href="/">Acceuil</a>
				</li>
				<?php
				$username = $_SESSION["username"];
				$queryCheck = "SELECT admin FROM user WHERE username = :username";
				$datas = [
					'username'=>$username,
				];
				$query = $pdo->prepare($queryCheck);
				$query->execute($datas);
				$check = $query->fetch();
				if ($check[0]) { ?>
					<li class="nav-item">
						<a class="nav-link" href="./admin.php">Admin</a>
					</li>
				<?php } ?>
				<li class="nav-item">
					<a class="nav-link" href="./profile.php">Profile</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="./new_post.php">Nouveau Post</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="./logout.php">Se déconnecter</a>
				</li>
			</ul>
		</div>
	</div>
</nav>