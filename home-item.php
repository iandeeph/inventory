<div class="row">
		<?php
			if (isset($_GET['detail'])) {
				include 'item.php';
			}else{
				?>
					<div class="col s12 grey lighten-2 mb-30">
						<h3 class="left-align">Item Category</h3>
					</div>
					<div class="container">
						<div class="col s12">
							<div class="col s12 m6 l4 align-center">
								<a href="./index.php?menu=item&detail=A">
									<div class="col s12 center grey-text">
										<i class="large material-icons center">laptop</i>
										<h5 class="center">Laptop</h5>
									</div>
								</a>
							</div>
							<div class="col s12 m6 l4 align-center">
								<a href="./index.php?menu=item&detail=B">
									<div class="col s12 center grey-text">
										<i class="large material-icons center">keyboard</i>
										<h5 class="center">Keyboard</h5>
									</div>
								</a>
							</div>
							<div class="col s12 m6 l4 align-center">
								<a href="./index.php?menu=item&detail=C">
									<div class="col s12 center grey-text">
										<i class="large material-icons center">mouse</i>
										<h5 class="center">Mouse</h5>
									</div>
								</a>
							</div>
							<div class="col s12 m6 l4 align-center">
								<a href="./index.php?menu=item&detail=D">
									<div class="col s12 center grey-text">
										<i class="large material-icons center">tv</i>
										<h5 class="center">Monitor</h5>
									</div>
								</a>
							</div>
							<div class="col s12 m6 l4 align-center">
								<a href="./index.php?menu=item&detail=E">
									<div class="col s12 center grey-text">
										<i class="large material-icons center">power</i>
										<h5 class="center">Adaptor Laptop</h5>
									</div>
								</a>
							</div>
							<div class="col s12 m6 l4 align-center">
								<a href="./index.php?menu=item&detail=F">
									<div class="col s12 center grey-text">
										<i class="large material-icons center">headset_mic</i>
										<h5 class="center">Headphone</h5>
									</div>
								</a>
							</div>
							<div class="col s12 m6 l4 align-center">
								<a href="./index.php?menu=item&detail=H">
									<div class="col s12 center grey-text">
										<i class="large material-icons center">phone_android</i>
										<h5 class="center">handphone</h5>
									</div>
								</a>
							</div>
							<div class="col s12 m6 l4 align-center">
								<a href="./index.php?menu=item&detail=K">
									<div class="col s12 center grey-text">
										<i class="large material-icons center">vpn_key</i>
										<h5 class="center">Kunci Kantor</h5>
									</div>
								</a>
							</div>
						</div>
					</div>
				<?php
			}
		?>
</div>
