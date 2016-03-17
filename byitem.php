<div class="row">
	<div class="col s12 grey lighten-2 mb-30">
		<h3 class="left-align">Rekapitulasi by Items</h3>
	</div>
	<div class="input-field col s6 m3 l3">
		<select id="trxOutIdInventory" name="trxOutIdInventory">
			<option value="" disabled selected>Pilih Transaksi</option>
			<option value="trxOut">Transaksi Keluar Item</option>
			<option value="trxIn">Transaksi Masuk Item</option>
		</select>
		<label>Transaksi</label>
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
<div id="trxOut" class="modal">
	<div class="modal-content">
		<div class="border-bottom mb-10"><h4>Transaksi Keluar Barang</h4></div>
		<div class="col s12">
			<form action="#" method="post" enctype="multipart/form-data">
				<div class="input-field col s12 m6 l6">
					<select id="trxOutIdInventory" name="trxOutIdInventory">
						<option value="" disabled selected>Pilih ID Inventory</option>
						<?php
							$invQry = "";
							$invQry = "SELECT idinventory FROM item WHERE status = 'Stock' ORDER BY idinventory ASC";
							if($resultInv = mysql_query($invQry)){
								if (mysql_num_rows($resultInv) > 0) {
									while ($rowInv = mysql_fetch_array($resultInv)) {
										$idInventoryTrxOut 	= $rowInv['idinventory'];
										?>
											<option value="<?php echo $idInventoryTrxOut; ?>"><?php echo $idInventoryTrxOut; ?></option>
										<?php
									}
								}
							}
						?>
					</select>
					<label>ID Inventory</label>
				</div>
				<div class="input-field col s12 m6 l6">
					<select id="trxOutUser" name="trxOutUser">
						<option value="" disabled selected>Pilih User</option>
						<?php
							$userQry = "";
							$userQry = "SELECT iduser, name FROM user WHERE name != '' ORDER BY name ASC";
							if($resultUser = mysql_query($userQry)){
								if (mysql_num_rows($resultUser) > 0) {
									while ($rowUser = mysql_fetch_array($resultUser)) {
										$idUserTrxOut 	= $rowUser['iduser'];
										$nameTrxOut 	= $rowUser['name'];
										?>
											<option value="<?php echo $idUserTrxOut; ?>"><?php echo $nameTrxOut; ?></option>
										<?php
									}
								}
							}
						?>
					</select>
					<label>User</label>
				</div>
				<div class="input-field col s12">
					<button type="submit" name="trxOutSubmit" class="waves-effect waves-light btn green darken-4 right mb-20">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="trxIn" class="modal">
	<div class="modal-content">
		<div class="border-bottom mb-10"><h4>Transaksi Keluar Barang</h4></div>
		<div class="col s12">
			<form action="#" method="post" enctype="multipart/form-data">
				<div class="input-field col s12 m6 l6">
					<select id="trxInIdInventory" name="trxInIdInventory">
						<option value="" disabled selected>Pilih ID Inventory</option>
						<?php
							$invQry = "";
							$invQry = "SELECT iduser, idinventory FROM item WHERE status != 'Stock' ORDER BY idinventory ASC";
							if($resultInv = mysql_query($invQry)){
								if (mysql_num_rows($resultInv) > 0) {
									while ($rowInv = mysql_fetch_array($resultInv)) {
										$idInventoryTrxIn 	= $rowInv['idinventory'];
										$iduserTrxIn 		= $rowInv['iduser'];
										?>
											<option value="<?php echo $idInventoryTrxIn; ?>"><?php echo $idInventoryTrxIn; ?></option>
										<?php
									}
								}
							}
						?>
					</select>
					<label>ID Inventory</label>
				</div>
				<div class="file-field input-field col s12 m6 l6">
					<input id="updateStatus" name="updateStatus" type="text" class="validate" required>
					<label for="updateStatus">Catatan</label>
				</div>
				<div class="input-field col s12">
					<input type="hidden" value="<?php echo $iduserTrxIn; ?>" name="iduserTrxIn">
					<button type="submit" name="trxInSubmit" class="waves-effect waves-light btn green darken-4 right mb-20">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>