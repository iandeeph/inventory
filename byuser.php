<div class="row">
	<div class="col s12 grey lighten-2 mb-30">
		<h3 class="left-align">Rekapitulasi by User</h3>
	</div>
	<div class="col s12">
		<table class="striped responsive-table col s12">
			<thead class="fixed">
				<!-- =================== to wide screen display -->
				<tr class="hide-on-med-and-down">
					<th width="5%" data-field="no">
						No.
					</th>
					<th width="10%" data-field="name">
						Nama
					</th>
					<th width="10%" data-field="division">
						Divisi
					</th>
					<?php
						$jenisItemQry = "";
						$jenisItemQry = "SELECT name FROM category ORDER BY name ASC";
						if($resultJenisItem = mysql_query($jenisItemQry)){
							if (mysql_num_rows($resultJenisItem) > 0) {
								while ($rowJenis = mysql_fetch_array($resultJenisItem)) {
									$jenisItem = $rowJenis['name'];
									?>
										<th width="7%" data-field="jenisItems">
											<?php echo $jenisItem?>
										</th>
									<?php
								}
							}
						}
					?>
				</tr>
				<!-- =================== to mobile screen display -->
				<tr class="hide-on-large-only">
					<th data-field="name">
						No.
					</th>
					<th data-field="name">
						Nama
					</th>
					<th data-field="name">
						Divisi
					</th>
					<?php
						$jenisItemQry = "";
						$jenisItemQry = "SELECT name FROM category ORDER BY name ASC";
						if($resultJenisItem = mysql_query($jenisItemQry)){
							if (mysql_num_rows($resultJenisItem) > 0) {
								while ($rowJenis = mysql_fetch_array($resultJenisItem)) {
									$jenisItem = $rowJenis['name'];
									?>
										<th data-field="jenisItems">
											<?php echo $jenisItem?>
										</th>
									<?php
								}
							}
						}
					?>
				</tr>
			</thead>
			<tbody>
				<?php
					// ======= mengambil semua user
					$userQry = "";
					$userQry = "SELECT *,
									division.name as divname,
									user.name as name 
								FROM user, division 
								WHERE user.iddivision = division.iddivision 
								ORDER BY division.name, user.name";
					$no=1;
					if($resultUserQry = mysql_query($userQry)){
						if (mysql_num_rows($resultUserQry) > 0) {
							while($rowUser = mysql_fetch_array($resultUserQry)){
								$idUser 		= $rowUser['iduser'];
								$nameUser 		= $rowUser['name'];
								$divisionUser 	= $rowUser['divname'];
								?>
									<tr>
										<td><?php echo $no; ?></td>
										<td><?php echo $nameUser; ?></td>
										<td><?php echo $divisionUser; ?></td>
										<?php
											$jenisItemQry = "";
											$jenisItemQry = "SELECT idcategory FROM category ORDER BY name ASC";
											if($resultJenisItem = mysql_query($jenisItemQry)){
												if (mysql_num_rows($resultJenisItem) > 0) {
													while ($rowJenis = mysql_fetch_array($resultJenisItem)) {
														$idjenisItem = $rowJenis['idcategory'];
														?>
															<td>
																<?php 
																	$idInventoryQry = "";
																	$idInventoryQry = "SELECT idcategory, name, serialNUmber, idinventory FROM item WHERE iduser = '".$idUser."' AND idcategory = '".$idjenisItem."'";
																	if($resulIdInventory = mysql_query($idInventoryQry)){
																		if (mysql_num_rows($resulIdInventory) > 0) {
																			while($rowIdInventory = mysql_fetch_array($resulIdInventory)){
																				$idInventory 	= $rowIdInventory['idinventory'];
																				$idCat 			= $rowIdInventory['idcategory'];
																				$name 			= $rowIdInventory['name'];
																				$serialNumber 	= $rowIdInventory['serialNUmber'];

																				$catQry = "";
																				$catQry = "SELECT name FROM category WHERE idcategory = '".$idCat."'";
																				if($resultCat = mysql_query($catQry)){
																					if (mysql_num_rows($resultCat) > 0) {
																						$rowCat = mysql_fetch_array($resultCat);
																						$category = $rowCat['name'];
																					}else{
																						$category = "Not Found";
																					}
																				}
																				?>
																					<a href="<?php echo "#modal".$idInventory; ?>" class="modal-trigger"><?php echo $idInventory;?></a>
																					<!-- =========== MODAL -->
																					<div id="<?php echo "modal".$idInventory; ?>" class="modal">
																						<div class="modal-content">
																							<div class="row">
																								<div class="col s12">
																									<h3 class="left-align"><?php echo $idInventory; ?></h3>
																								</div>
																								<div class="col s12">
																									<table class="striped responsive-table col s12">
																										<thead>
																											<!-- =================== to wide screen display -->
																											<tr class="hide-on-small-only">
																												<th width="7%" data-field="category">
																													Jenis
																												</th>
																												<th width="15%" data-field="name">
																													Nama
																												</th>
																												<th width="13%" data-field="serialNumber">
																													S/N
																												</th>
																											</tr>
																										</thead>
																										<tbody>
																											<tr>
																												<td><?php echo $category; ?></td>
																												<td><?php echo $name; ?></td>
																												<td><?php echo $serialNumber; ?></td>
																											</tr>
																										</tbody>
																									</table>
																								</div>
																							</div>
																						</div>
																						<div class="modal-footer col s12 mb-10">
																							<a href="#!" class="mr-10 waves-effect modal-action modal-close waves-light btn green darken-4 right">OK</a>
																						</div>
																					</div>
																					<!-- =========== MODAL -->
																					<br>
																				<?php
																			}
																		}else{echo "-";}
																	}
																?>
															</td>
														<?php
													}
												}
											}
										?>
									</tr>
								<?php
								$no++;
							}
						}
					}
				?>
			</tbody>
		</table>
	</div>
</div>