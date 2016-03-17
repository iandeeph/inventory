<div class="row">
	<div class="col s12 grey lighten-2 mb-30">
		<h3 class="left-align">Transaksi Keluar Item</h3>
	</div>
	<div class="col s12 mt-30 center container">
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
			<div class="input-field col s12 m6 l5">
				<select id="trxOutUser" name="trxOutUser">
					<option value="" disabled selected>Pilih User</option>
					<?php
						$userQry = "";
						$userQry = "SELECT iduser, name FROM user ORDER BY name ASC";
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
			<div class="input-field col s12 mb-20">
				<button type="submit" name="trxOutSubmit" class="waves-effect waves-light btn green darken-4 right">Submit</button>
			</div>
		</form>
	</div>
</div>