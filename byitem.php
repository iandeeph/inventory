<div class="row">
	<div class="col s12 grey lighten-2 mb-30">
		<h3 class="left-align">Rekapitulasi by Items</h3>
	</div>
	<div class="col s12">
		<table class="striped responsive-table col s12">
			<thead>
				<!-- =================== to wide screen display -->
				<tr class="hide-on-small-only">
					<th width="5%" data-field="idinventory">
						ID
					</th>
					<th width="7%" data-field="dateIn">
						Tgl Masuk
					</th>
					<th width="7%" data-field="dateOut">
						Tgl Keluar
					</th>
					<th width="10%" data-field="category">
						Jenis
					</th>
					<th width="20%" data-field="name">
						Nama
					</th>
					<th width="13%" data-field="serialNumber">
						S/N
					</th>
					<th width="7%" data-field="status">
						Status
					</th>
					<th width="7%" data-field="iduser">
						User
					</th>
					<th width="7%" data-field="lastIdUser">
						Last User
					</th>
					<th width="10%" data-field="notes">
						Keterangan
					</th>
				</tr>
				<!-- =================== to mobile screen display -->
				<tr class="hide-on-med-and-up">
					<th  data-field="idinventory">
						ID
					</th>
					<th  data-field="dateIn">
						Tgl Masuk
					</th>
					<th  data-field="dateOut">
						Tgl Keluar
					</th>
					<th  data-field="category">
						Jenis
					</th>
					<th  data-field="name">
						Nama
					</th>
					<th  data-field="serialNumber">
						S/N
					</th>
					<th  data-field="status">
						Status
					</th>
					<th  data-field="iduser">
						User
					</th>
					<th  data-field="lastIdUser">
						Last User
					</th>
					<th  data-field="notes">
						Keterangan
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$itemQry = "";
					$itemQry = "SELECT *,DATE_FORMAT(dateIn, '%e %b %Y') as tglMasuk, DATE_FORMAT(dateOut, '%e %b %Y') as tglKeluar FROM item ORDER BY idinventory ASC";
					if($resultItemQry = mysql_query($itemQry)){
						if (mysql_num_rows($resultItemQry) > 0) {
							while ($rowItem = mysql_fetch_array($resultItemQry)) {
								$iditem      	= $rowItem['iditem'];
								$idinventory	= $rowItem['idinventory'];
								$dateIn      	= $rowItem['tglMasuk'];
								$dateOut 		= $rowItem['tglKeluar'];
								$name  			= $rowItem['name'];
								$category   	= $rowItem['idcategory'];
								$serialNumber	= $rowItem['serialNumber'];
								$status 		= $rowItem['status'];
								$iduser 		= $rowItem['iduser'];
								$lastIdUser 	= $rowItem['lastIdUser'];
								$notes 			= $rowItem['notes'];

								$userQry = "";
								$userQry = "SELECT * FROM user WHERE iduser = '".$iduser."' LIMIT 1";
								if($resultUserQry = mysql_query($userQry)){
									if (mysql_num_rows($resultUserQry) > 0) {
										$rowUser = mysql_fetch_array($resultUserQry);
										$user = $rowUser['name'];
									}else{
										$user = "-";
									}
								}

								$userLastQry = "";
								$userLastQry = "SELECT * FROM user WHERE iduser = '".$lastIdUser."' LIMIT 1";
								if($resultUserLast = mysql_query($userLastQry)){
									if (mysql_num_rows($resultUserLast) > 0) {
										$rowUserLast = mysql_fetch_array($resultUserLast);
										$lastUser = $rowUserLast['name'];
									}else{
										$lastUser = "-";
									}
								}

								$catQry = "";
								$catQry = "SELECT name FROM category WHERE idcategory = '".$category."'";
								if($resultCatr = mysql_query($catQry)){
									if (mysql_num_rows($resultCatr) > 0) {
										$rowCat = mysql_fetch_array($resultCatr);
										$category = $rowCat['name'];
									}else{
										$category = "Not Found";
									}
								}

								?>
									<tr>
										<td><?php echo $idinventory; ?></td>
										<td><?php echo $dateIn; ?></td>
										<td><?php echo ($dateOut == "")?"-":$dateOut; ?></td>
										<td><?php echo $category; ?></td>
										<td><?php echo $name; ?></td>
										<td><?php echo $serialNumber; ?></td>
										<td><?php echo $status; ?></td>
										<td><?php echo $user; ?></td>
										<td><?php echo $lastUser; ?></td>
										<td class="break-word"><?php echo $notes; ?></td>
									</tr>
								<?php
							}
						}
					}
				?>
			</tbody>
		</table>
	</div>
</div>