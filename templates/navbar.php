<nav>
	<ul class="navbar">
		<li class="first navbar-li">
			<a class="nav-link" href="/profile">Profil</a>
		</li>
		<li class="navbar-li">
			<a class="nav-link" href="/">Acceuil</a>
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
			<li>
				<a href="/admin/admin_post.php">Admin</a>
			</li>
		<?php } ?>
		<li>
			<a href="/post/new_post.php">Nouveau Post</a>
		</li>
		<li>
			<a href="./logout.php">Se déconnecter</a>
		</li>
	</ul>
</nav>