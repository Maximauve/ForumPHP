<header>
<!-- NAV BAR -->
	<nav>
		<ul>
			<li>
				<a href="./profile.php">Profil</a>
			</li>
			<li>
				<a href="/">Acceuil</a>
			</li>
			<?php
			$mail = $_SESSION["mail"];
			$queryCheck = "SELECT admin FROM user WHERE mail = :mail";
			$datas = [
				'mail'=>$mail,
			];
			$query = $pdo->prepare($queryCheck);
			$query->execute($datas);
			$check = $query->fetch();
			if ($check[0]) { ?>
				<li>
					<a href="./admin.php">Admin</a>
				</li>
			<?php } ?>
			<li>
				<a href="./new_post.php">Nouveau Post</a>
			</li>
			<li>
				<a href="./logout.php">Se déconnecter</a>
			</li>
		</ul>
	</nav>

<!-- PROFILE ZONE -->
	<div>
		<img class="user-icon" src="" />
	</div>
</header>