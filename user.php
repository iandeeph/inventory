<div class="row">
	<div class="col s12 grey lighten-2 mb-30">
		<h3 class="left-align">User Management</h3>
	</div>
	<div class="col s12">
		<form action="#" method="post" enctype="multipart/form-data">
			<div class="col s12 mb-30">
				<?php
					if(isset($_SESSION['privilege']) && $_SESSION['privilege'] == '1'){
						?>
							<a id="delSelectionUserButton" href="#modalDelUser" class="waves-effect waves-light btn red accent-4 disabled mt-20" disabled><i class="material-icons left">delete</i>Delete</a>
						<?php
					}
				?>
				<a href="#modalAddUser" class="modal-trigger btn-floating btn-large waves-effect waves-light green darken-4 right"><i class="material-icons">person_add</i></a>
			</div>
			<table class="striped responsive-table col s12">
				<thead>
					<!-- =================== to wide screen display -->
					<tr class="hide-on-small-only">
						<th width="5%" data-field="selectAll">
							<p>
								<input type="checkbox" id="checkAllUser" />
								<label for="checkAllUser"></label>
							</p>
						</th>
						<th width="25%" data-field="name">
							Nama
						</th>
						<th width="20%" data-field="division">
							Divisi
						</th>
						<th width="10%" data-field="division">
							Action
						</th>
					<!-- =================== to mobile screen display -->
					<tr class="hide-on-med-and-up">
						<th data-field="selectAll">
							<p>
								<input type="checkbox" id="checkAllUserSmall" />
								<label for="checkAllUserSmall"></label>
							</p>
						</th>
						<th data-field="name">
							Nama
						</th>
						<th data-field="division">
							Divisi
						</th>
						<th data-field="division">
							Action
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$userQry = "";
						$userQry = "SELECT *,
										division.iddivision as iddivision,
										division.name as divname,
										user.name as name 
									FROM user, division 
									WHERE user.iddivision = division.iddivision 
									ORDER BY division.name, user.name";
						if($resultUserQry = mysql_query($userQry)){
							if (mysql_num_rows($resultUserQry) > 0) {
								while($rowUser = mysql_fetch_array($resultUserQry)){
									$iddivision 	= $rowUser['iddivision'];
									$iduser 		= $rowUser['iduser'];
									$nameUser 		= $rowUser['name'];
									$divisionUser 	= $rowUser['divname'];

									$cekUserQry = "";
								    $cekUserQry = "SELECT count(idinventory) as countId FROM item WHERE iduser = '".$iduser."'";
								    if($resultCekUser = mysql_query($cekUserQry)){
								        if (mysql_num_rows($resultCekUser) > 0) {
								            $rowCekUser = mysql_fetch_array($resultCekUser);
								            $cekUser = $rowCekUser['countId'];
								        }
								    }
									?>
										<tr>
											<td>
												<input name="checkboxUser[]" type="checkbox" id="<?php echo "checkboxUser".$iduser; ?>" value="<?php echo $iduser; ?>" <?php echo ($cekUser > 0)?"disabled":""; ?>/>
												<label for="<?php echo "checkboxUser".$iduser; ?>"></label>
												<?php
													if($cekUser > 0){
														?>
															<a href="#modalConfirmation" class="modal-trigger waves-effect waves-light" title="Kembalikan Item Ke-Stock Untuk Menghapus User.."><i class="material-icons edit">help</i></a>
														<?php
													}
												?>
											</td>
											<td><?php echo $nameUser; ?></td>
											<td><?php echo $divisionUser; ?></td>
											<td>
												<a href="<?php echo "#modalEditUser".$iduser; ?>" class="btn-floating btn modal-trigger waves-effect waves-light btn green darken-2"><i class="material-icons edit">edit</i></a>
											</td>
										</tr>
										<!-- ========================================= MODAL - UPDATE ITEM -->
										<div id="<?php echo "modalEditUser".$iduser; ?>" class="modal">
											<div class="modal-content">
												<div class="border-bottom mb-10">
													<h4>Edit User</h4>
												</div>
												<div class="col s12 mt-30 center container">
													<div class="file-field input-field col s12 m6 l6">
														<input id="<?php echo "name".$iduser; ?>" name="<?php echo "name".$iduser; ?>" value="<?php echo $nameUser; ?>" type="text" class="validate" required>
														<label for="<?php echo "name".$iduser; ?>">ID Inventory</label>
													</div>
													<div class="input-field col s12 m6 l6">
														<select id="<?php echo "division".$iduser; ?>" name="<?php echo "division".$iduser; ?>">
															<option value="" disabled selected>Pilih Divisi</option>
																<?php
																	$divQry = "";
																	$divQry = "SELECT iddivision, name FROM division ORDER BY name ASC";
																	if($resultDiv = mysql_query($divQry)){
																		if (mysql_num_rows($resultDiv) > 0) {
																			while($rowDiv = mysql_fetch_array($resultDiv)){
																				$iddivisionUpdate 	= $rowDiv['iddivision'];
																				$nameDivUpdate 		= $rowDiv['name'];
																				?>
																					<option <?php echo ($iddivisionUpdate == $iddivision)?"selected":""; ?> value="<?php echo $iddivisionUpdate; ?>"><?php echo $nameDivUpdate; ?></option>
																				<?php
																			}
																		}
																	}
																?>
														</select>
														<label>Divisi User</label>
													</div>
													<div class="input-field col s12 mb-30">
														<input value="<?php echo $iduser; ?>" name="<?php echo "hiddeniduser".$iduser; ?>" type="hidden">
														<button type="submit" name="<?php echo "updateUserButton".$iduser; ?>" class="waves-effect waves-light btn green darken-4 right">Update</button>
														<a href="#!" class="ml-10 mr-10 modal-action modal-close waves-effect waves-light btn blue darken-4 right">Cancel</a>
													</div>
												</div>
											</div>
										</div>
									<?php
									// ============================== BUTTON UPDATE CLICK ==========================================================
									$btnUpdateIdUser = "updateUserButton".$iduser;
									if(isset($_POST[$btnUpdateIdUser])){
										$name 		= "name".$iduser;
										$division 	= "division".$iduser;
										$iduser 	= "hiddeniduser".$iduser;

										$postname 		= $_POST[$name];
										$postdivision	= $_POST[$division];
										$postiduser 	= $_POST[$iduser];

										$updateUserQry = "UPDATE user SET
															name = '".$postname."',
															iddivision = '".$postdivision."'
															WHERE iduser = '".$postiduser."'";
									// ================================== LOGGING
										$logUserQry = "";
										$logUserQry = "SELECT * FROM user WHERE iduser = '".$postiduser."' LIMIT 1";
										if($resultLogUser = mysql_query($logUserQry)){
											if (mysql_num_rows($resultLogUser) > 0) {
												$rowLogUser = mysql_fetch_array($resultLogUser);
												$rowname 		= $rowLogUser['name'];
												$rowdivision	= $rowLogUser['iddivision'];

												 $loggingText = "
												 				OLD DATA
												 				---------------------------------------
												 				Name 		: ".$rowname."
							                    				Division 	: ".$rowdivision."

							                    				NEW DATA
							                    				----------------------------------------
							                    				Name 		: ".$postname."
							                    				Division 	: ".$postdivision."
							                    				";
											}
										}
											echo $updateUserQry;
										// ================================== LOGGING
										if(mysql_query($updateUserQry)){
											logging($now, $user, "Update User", $loggingText, $postiduser);
									        header('Location: ./index.php?menu=user');
									    }else{
									    	echo "ERROR: Could not able to execute ".$updateUserQry.". " . mysql_error($conn);
									    }
									}
								}
							}
						}
					?>
				</tbody>
			</table>
			<div id="modalDelUser" class="modal">
				<div class="modal-content">
					<h4>konfirmasi Hapus</h4>
					<h5>Apakah anda yakin ingin menghapus?</h5>
				</div>
				<div class="modal-footer col s12 mb-10">
					<button type="submit" name="btnDeleteUser" class="mr-10 waves-effect waves-light btn red darken-4 right">Yes</button>
					<a href="#!" class="ml-10 mr-10 modal-action modal-close waves-effect waves-light btn blue darken-4 right">Cancel</a>
				</div>
			</div>
		</form>
		<div id="modalAddUser" class="modal">
			<div class="modal-content">
				<div class="border-bottom mb-10"><h4>Tambah User Baru</h4></div>
				<div class="col s12 mt-30 center container">
					<form action="#" method="post" enctype="multipart/form-data">
						<div class="file-field input-field col s12 m6 l6">
							<input id="addName" name="addName" type="text" class="validate" required>
							<label for="addName">Nama</label>
						</div>
						<div class="input-field col s12 m6 l6">
							<select id="addUserDivision" name="addUserDivision">
								<option value="" disabled selected>Pilih Divisi</option>
								<?php
									$divQry = "";
									$divQry = "SELECT iddivision, name FROM division ORDER BY name ASC";
									if($resultDiv = mysql_query($divQry)){
										if (mysql_num_rows($resultDiv) > 0) {
											while($rowDiv = mysql_fetch_array($resultDiv)){
												$iddivisionAdd 	= $rowDiv['iddivision'];
												$nameDivAdd 		= $rowDiv['name'];
												?>
													<option value="<?php echo $iddivisionAdd; ?>"><?php echo $nameDivAdd; ?></option>
												<?php
											}
										}
									}
								?>
							</select>
							<label>Divisi</label>
							<a href="#modalAddDivision" class="blue-text left modal-trigger">[+] Tambah Divisi</a>
						</div>
						<div class="input-field col s12 mb-20">
							<button type="submit" name="addUserButton" class="waves-effect waves-light btn green darken-4 right">Add</button>
							<a href="#!" class="ml-10 mr-10 modal-action modal-close waves-effect waves-light btn blue darken-4 right">Cancel</a>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="modalAddDivision" class="modal">
			<div class="modal-content">
				<div class="border-bottom mb-10"><h4>Tambah Divisi Baru</h4></div>
				<div class="col s12 mt-30 center container">
					<form action="#" method="post" enctype="multipart/form-data">
						<div class="col s12 m6 l6">
							<table class="stripped">
								<thead>
									<tr class="hide-on-small-only">
										<th data-field="No">
											No.
										</th>
										<th data-field="name">
											Nama
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$divQry = "";
									$divQry = "SELECT iddivision, name FROM division ORDER BY name ASC";
									if($resultDiv = mysql_query($divQry)){
										if (mysql_num_rows($resultDiv) > 0) {
											while($rowDiv = mysql_fetch_array($resultDiv)){
												$nameDivAdd 	= $rowDiv['name'];
												?>
												<tr>
													<td>
														<?php echo $no; ?>
													</td>
													<td>
														<?php echo $nameDivAdd; ?>
													</td>
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
						<div class="file-field input-field col s12 m6 l6">
							<input id="addName" name="addName" type="text" class="validate" required>
							<label for="addName">Nama Divisi Baru</label>
						</div>
						<div class="input-field col s12 mb-20">
							<button type="submit" name="addDivisionButton" class="waves-effect waves-light btn green darken-4 right">Tambah</button>
							<a href="#!" class="ml-10 mr-10 modal-action modal-close waves-effect waves-light btn blue darken-4 right">Cancel</a>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="modalConfirmation" class="modal">
			<div class="modal-content">
				<h5>Kembalikan Item Ke-Stock Untuk Menghapus User..</h5>
			</div>
			<div class="modal-footer col s12 mb-10">
				<a href="#!" class="mr-10 waves-effect modal-action modal-close waves-light btn green darken-4 right">Yes</a>
			</div>
		</div>
	</div>
</div>