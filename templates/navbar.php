<nav>
	<ul class="navbar">
		<li class="first navbar-li">
			<a class="nav-link" href="/Profile">Profil</a>
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
				<a href="/Admin/post.php">Admin</a>
			</li>
		<?php } ?>
		<li>
			<a href="/Post/newPost.php">Nouveau Post</a>
		</li>
		<li>
			<a href="/Favorites/index.php">Favoris</a>
		</li>
		<li>
			<a href="/Connections/logout.php">Se déconnecter</a>
		</li>
		<form action="/Search/index.php" method="post" enctype="multipart/form-data">
			<input type="text" name="search" placeholder="Search" required>
			<label>Post :<input type="radio" name="choice" value="post" checked></input></label>
			<label>User :<input type="radio" name="choice" value="user"></input></label>
			<button type="submit" name="btnsearch" id="confirmbtn">Search</button>

		</form>
	</ul>
</nav>