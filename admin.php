<div class="row">
	<div class="col s12 border-bottom grey lighten-2 mb-50">
		<h3 class="left-align">Manage User</h3>
	</div>
	<div class="col s12">
		<form action="#" method="post" enctype="multipart/form-data">
			<div class="col s12 mb-30">
				<a id="delSelectionUserButton" href="#modalDelUserItems" class="waves-effect waves-light btn red accent-4 disabled" disabled><i class="material-icons left">delete</i>Delete</a>
				<a href="#modalAddUserItems" class="modal-trigger btn-floating btn-large waves-effect waves-light green darken-4 right"><i class="material-icons">add</i></a>
			</div>
			<table class="stripped responsive-table col s12">
				<thead>
					<tr>
						<th data-field="id">
							<p>
								<input type="checkbox" id="checkAll" />
								<label for="checkAll"></label>
							</p>
						</th>
						<th data-field="username">
							Username
						</th>
						<th data-field="password">
							Password
						</th>
						<th data-field="name">
							Name
						</th>
						<th data-field="permission">
							Permission
						</th>
						<th data-field="action">
							Action
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if($resultUserQry = mysql_query("SELECT * FROM admin")){
							if (mysql_num_rows($resultUserQry) > 0) {
								while ($rowUser = mysql_fetch_array($resultUserQry)) {
									$iduser         = $rowUser['idadmin'];
									$username       = $rowUser['username'];
									$passwordUser 	= $rowUser['password'];
									$nameUser  		= $rowUser['name'];
									$privilege 		= $rowUser['privilege'];
									?>
									<tr>
										<td>
											<p>
												<input name="checkboxUser[]" type="checkbox" id="<?php echo $iduser; ?>" value="<?php echo $iduser; ?>" />
												<label for="<?php echo $iduser; ?>"></label>
											</p>
										</td>
										<td><?php echo $username; ?></td>
										<td><?php echo $passwordUser; ?></td>
										<td><?php echo $nameUser; ?></td>
										<td><?php echo ($privilege == 1) ? "Administrator":"Operator"; ?></td>
										<td><a href="<?php echo "#modalEditUser".$iduser; ?>" class="btn-floating btn-large modal-trigger waves-effect waves-light btn blue darken-4"><i class="material-icons left">edit</i></a></td>
										<!-- ==================================== MODAL -->
										<div id="<?php echo "modalEditUser".$iduser; ?>" class="modal">
											<div class="modal-content">
												<div class="border-bottom mb-10"><h4>Edit User</h4></div>
												<div class="col s12 mt-30 center container">
													<div class="file-field input-field col s12 m6 l6">
														<input value="<?php echo $username; ?>" id="<?php echo "UserUsername".$iduser; ?>" name="<?php echo "UserUsername".$iduser; ?>" type="text" class="validate" required>
														<label for="<?php echo "UserUsername".$iduser; ?>">Username</label>
													</div>
													<div class="file-field input-field col s12 m6 l6">
														<input value="<?php echo $passwordUser; ?>" id="<?php echo "UserPassword".$iduser; ?>" name="<?php echo "UserPassword".$iduser; ?>" type="text" class="validate" required>
														<label for="<?php echo "UserPassword".$iduser; ?>">Password</label>
													</div>
													<div class="file-field input-field col s12 m6 l6">
														<input value="<?php echo $nameUser; ?>" id="<?php echo "UserName".$iduser; ?>" name="<?php echo "UserName".$iduser; ?>" type="text" class="validate" required>
														<label for="<?php echo "UserName".$iduser; ?>">Name</label>
													</div>
													<div class="input-field col s12 m6 l6">
														<select id="<?php echo "UserPermission".$iduser; ?>" name="<?php echo "UserPermission".$iduser; ?>">
															<option value="" disabled>Choose your option</option>
															<option <?php echo ($privilege == 1) ? "selected":""; ?> value="1">Administrator</option>
															<option <?php echo ($privilege == 2) ? "selected":""; ?> value="2">User</option>
														</select>
														<label>Permission</label>
													</div>
													<div class="input-field col s12 mb-50">
														<input value="<?php echo $iduser; ?>" name="<?php echo "hiddeniduser".$iduser; ?>" type="hidden">
														<button type="submit" name="<?php echo "updateUserButton".$iduser; ?>" class="waves-effect waves-light btn green darken-4 right">Update</button>
													</div>
												</div>
											</div>
										</div>
									</tr>
									<?php
									// ============================== BUTTON UPDATE CLICK ==========================================================
									$btnUpdateIdUser	= "updateUserButton".$iduser;
									$hiddeniduser 		= "hiddeniduser".$iduser;
									$UserUsername 		= "UserUsername".$iduser;
									$UserPassword 		= "UserPassword".$iduser;
									$UserName 			= "UserName".$iduser;
									$UserPermission 	= "UserPermission".$iduser;
									if(isset($_POST[$btnUpdateIdUser])){
										$postUpdateIdUser 		= $_POST[$hiddeniduser];
										$postUpdateUsername 	= $_POST[$UserUsername];
										$postUpdatePassword 	= $_POST[$UserPassword];
										$postUpdateName 		= $_POST[$UserName];
										$postUpdatePrivilege 	= $_POST[$UserPermission];

										$permissionNew = ($postUpdatePrivilege == '1')?"Administrator":"User";

										$updateUserQry = "UPDATE admin SET username = '".$postUpdateUsername."', password = '".$postUpdatePassword."', name = '".$postUpdateName."', privilege = '".$postUpdatePrivilege."' 
														WHERE idadmin = '".$postUpdateIdUser."'";
										// ================================== LOGGING
											$updateLogUserQry = "";
											$updateLogUserQry = "SELECT username, password, name, privilege FROM admin WHERE idadmin = '".$postUpdateIdUser."' LIMIT 1";
											if($resultUpdateUserQry = mysql_query($updateLogUserQry)){
												if (mysql_num_rows($resultUpdateUserQry) > 0) {
													$rowUpdateUser = mysql_fetch_array($resultUpdateUserQry);
													$usernameUpdateUser		= $rowUpdateUser['username'];
													$passwordUpdateUser    	= $rowUpdateUser['password'];
													$nameUpdateUser    		= $rowUpdateUser['name'];
													$privilegeUpdateUser 	= $rowUpdateUser['privilege'];

													$permission = ($privilegeUpdateUser == '1')?"Administrator":"User";

													$loggingText = "
													 				OLD DATA
													 				--------------------------------------
																	Username    : ".$usernameUpdateUser."
											                        Password    : ".$passwordUpdateUser."
											                        Name        : ".$nameUpdateUser."
											                        Permission  : ".$permission."

													 				NEW DATA
													 				--------------------------------------
																	Username    : ".$postUpdateUsername."
											                        Password    : ".$postUpdatePassword."
											                        Name        : ".$postUpdateName."
											                        Permission  : ".$permissionNew."";
												}
											}
										// ================================== LOGGING
										if(mysql_query($updateUserQry)){
											logging($now, $user, "Update User", $loggingText, $postUpdateIdUser);
									        header('Location: ./index.php?menu=admin');
									    }else{
									    	alertBox("ERROR: Could not able to execute " . mysql_error($conn));
									    }
									}
								}
							}
						}
					?>
				</tbody>
			</table>
			<div id="modalDelUserItems" class="modal">
				<div class="modal-content">
					<h4>Konfirmasi Hapus</h4>
					<h5>Apakah anda yakin ingin menghapus?</h5>
				</div>
				<div class="modal-footer col s12 mb-30">
					<button type="submit" name="btnDeleteAdmin" class="waves-effect waves-light btn green darken-4 right">Yes</button>
					<a href="#!" class="modal-action modal-close waves-effect waves-light btn blue darken-4 right">Cancel</a>
				</div>
			</div>
		</form>
		<div id="modalAddUserItems" class="modal">
			<div class="modal-content">
				<div class="border-bottom mb-10"><h4>Add New User</h4></div>
				<div class="col s12 mt-30 center container">
					<form action="#" method="post" enctype="multipart/form-data">
						<div class="file-field input-field col s12">
							<input id="addUserUsername" name="addUserUsername" type="text" class="validate" required>
							<label for="addUserUsername">Username</label>
						</div>
						<div class="file-field input-field col s12 m6 l6">
							<input id="addUserPassword" name="addUserPassword" type="password" class="validate" required>
							<label for="addUserPassword">Password</label>
						</div>
						<div class="file-field input-field col s12 m6 l6">
							<input id="addUserReenterPassword" name="addUserReenterPassword" type="password" class="validate" required>
							<label for="addUserReenterPassword">Reenter Password</label>
						</div>
						<span class="col s12 left-align" id="txtConfirmPassword"></span>
						<div class="file-field input-field col s12 m6 l6">
							<input id="addUserName" name="addUserName" type="text" class="validate" required>
							<label for="addUserName">Name</label>
						</div>
						<div class="input-field col s12 m6 l6">
							<select id="addUserPermission" name="addUserPermission">
								<option value="" disabled selected>Choose your option</option>
								<option value="1">Administrator</option>
								<option value="2">Operator</option>
							</select>
							<label>Permission</label>
						</div>
						<div class="input-field col s12 mb-50">
							<button type="submit" name="addAdminButton" class="waves-effect waves-light btn green darken-4 right">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>