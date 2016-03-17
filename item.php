<div class="row">
	<div class="col s12 grey lighten-2 mb-30">
		<h3 class="left-align">Item Management</h3>
	</div>
	<div class="col s12">
		<form action="#" method="post" enctype="multipart/form-data">
			<div class="col s12 mb-30">
				<?php
					if(isset($_SESSION['privilege']) && $_SESSION['privilege'] == '1'){
						?>
							<a id="delSelectionItemButton" href="#modalDelItem" class="waves-effect waves-light btn red accent-4 disabled mt-20" disabled><i class="material-icons left">delete</i>Delete</a>
						<?php
					}
				?>
				<a href="#modalAddItem" class="modal-trigger btn-floating btn-large waves-effect waves-light green darken-4 right"><i class="material-icons">add</i></a>
			</div>
			<table class="striped responsive-table col s12">
				<thead>
					<!-- =================== to wide screen display -->
					<tr class="hide-on-small-only">
						<th width="5%" data-field="selectAll">
							<p>
								<input type="checkbox" id="checkAllItem" />
								<label for="checkAllItem"></label>
							</p>
						</th>
						<th width="5%" data-field="idinventory">
							ID
						</th>
						<th width="7%" data-field="category">
							Jenis
						</th>
						<th width="15%" data-field="name">
							Nama
						</th>
						<th width="13%" data-field="serialNumber">
							S/N
						</th>
						<th width="7%" data-field="status">
							Status
						</th>
						<th width="7%" data-field="dateIn">
							Tgl Masuk
						</th>
						<th width="7%" data-field="action">
							Action
						</th>
					</tr>
					<!-- =================== to mobile screen display -->
					<tr class="hide-on-med-and-up">
						<th data-field="selectAll">
							<p>
								<input type="checkbox" id="checkAllItemSmall" />
								<label for="checkAllItemSmall"></label>
							</p>
						</th>
						<th data-field="idinventory">
							ID
						</th>
						<th data-field="category">
							Jenis
						</th>
						<th  data-field="name">
							Nama
						</th>
						<th data-field="serialNumber">
							S/N
						</th>
						<th data-field="status">
							Status
						</th>
						<th data-field="dateIn">
							Tgl Masuk
						</th>
						<th data-field="action">
							Action
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$itemQry = "";
						$itemQry = "SELECT *, DATE_FORMAT(dateIn, '%e %b %Y') as tglMasuk FROM item ORDER BY idinventory ASC";
						if($resultItemQry = mysql_query($itemQry)){
							if (mysql_num_rows($resultItemQry) > 0) {
								while ($rowItem = mysql_fetch_array($resultItemQry)) {
									$iditem      	= $rowItem['iditem'];
									$idinventory	= $rowItem['idinventory'];
									$name  			= $rowItem['name'];
									$idcategory   	= $rowItem['idcategory'];
									$serialNumber	= $rowItem['serialNumber'];
									$dateIn			= $rowItem['tglMasuk'];
									$dateIn2		= $rowItem['dateIn'];
									$status 		= $rowItem['status'];

									$catQry = "";
									$catQry = "SELECT name FROM category WHERE idcategory = '".$idcategory."'";
									if($resultCat = mysql_query($catQry)){
										if (mysql_num_rows($resultCat) > 0) {
											$rowCat = mysql_fetch_array($resultCat);
											$category = $rowCat['name'];
										}else{
											$category = "Not Found";
										}
									}
									?>
										<tr>
											<td class="valign-wrapper">
												<input name="checkboxItem[]" type="checkbox" id="<?php echo "checkboxItem".$iditem; ?>" value="<?php echo $iditem;?>" <?php echo ($status != "Stock")?"disabled":"";?>/>
												<label for="<?php echo "checkboxItem".$iditem; ?>"></label>
												<?php
													if($status != "Stock"){
														?>
															<a href="#modalConfirmation" class="modal-trigger waves-effect waves-light" title="Kembalikan Item Ke-Stock Untuk Menghapus Item.."><i class="material-icons edit">help</i></a>
														<?php
													}
												?>
											</td>
											<td><?php echo $idinventory; ?></td>
											<td><?php echo $category; ?></td>
											<td><?php echo $name; ?></td>
											<td><?php echo $serialNumber; ?></td>
											<td><?php echo $status; ?></td>
											<td><?php echo $dateIn; ?></td>
											<td>
												<a href="<?php echo "#modalEditItem".$iditem; ?>" class="btn-floating btn modal-trigger waves-effect waves-light btn green darken-2"><i class="material-icons edit">edit</i></a>
											</td>
										</tr>
										<!-- ========================================= MODAL - UPDATE ITEM -->
										<div id="<?php echo "modalEditItem".$iditem; ?>" class="modal">
											<div class="modal-content">
												<div class="border-bottom mb-10">
													<h4>Edit Item</h4>
												</div>
												<div class="col s12 mt-30 center container">
													<div class="file-field input-field col s12 m6 l6">
														<input id="<?php echo "idinventory".$iditem; ?>" name="<?php echo "idinventory".$iditem; ?>" value="<?php echo $idinventory; ?>" type="text" class="validate" required>
														<label for="<?php echo "idinventory".$iditem; ?>">ID Inventory</label>
													</div>
													<div class="input-field col s12 m6 l6">
														<select id="<?php echo "category".$iditem; ?>" name="<?php echo "category".$iditem; ?>">
															<option value="" disabled selected>Pilih Jenis Item</option>
																<?php
																	$catQry = "";
																	$catQry = "SELECT idcategory, name FROM category ORDER BY name ASC";
																	if($resultCat = mysql_query($catQry)){
																		if (mysql_num_rows($resultCat) > 0) {
																			while ($rowCat = mysql_fetch_array($resultCat)) {
																				$idcategoryUpdate 	= $rowCat['idcategory'];
																				$nameUpdate 		= $rowCat['name'];
																				?>
																					<option <?php echo ($idcategoryUpdate == $idcategory)?"selected":""; ?> value="<?php echo $idcategoryUpdate; ?>"><?php echo $nameUpdate; ?></option>
																				<?php
																			}
																		}
																	}
																?>
														</select>
														<label>Jenis Item</label>
													</div>
													<div class="file-field input-field col s12 m6 l6">
														<input id="<?php echo "name".$iditem; ?>" name="<?php echo "name".$iditem; ?>" value="<?php echo $name; ?>" type="text" class="validate" required>
														<label for="<?php echo "name".$iditem; ?>">Nama</label>
													</div>
													<div class="file-field input-field col s12 m6 l6">
														<input id="<?php echo "serialNumber".$iditem; ?>" name="<?php echo "serialNumber".$iditem; ?>" value="<?php echo $serialNumber; ?>" type="text" class="validate" required>
														<label for="<?php echo "serialNumber".$iditem; ?>">Serial Number</label>
													</div>
													<div class="input-field col s12 m6 l6">
														<label  class="active" for="<?php echo "dateIn".$iditem; ?>">Date From</label>
														<input name="<?php echo "dateIn".$iditem; ?>" id="<?php echo "dateIn".$iditem; ?>" value="<?php echo date('j F, Y', strtotime($dateIn2)); ?>" type="date" class="datepicker">
													</div>
													<div class="input-field col s12 mb-30">
														<input value="<?php echo $iditem; ?>" name="<?php echo "hiddeniditem".$iditem; ?>" type="hidden">
														<button type="submit" name="<?php echo "updateItemButton".$iditem; ?>" class="waves-effect waves-light btn green darken-4 right">Update</button>
														<a href="#!" class="ml-10 mr-10 modal-action modal-close waves-effect waves-light btn blue darken-4 right">Cancel</a>
													</div>
												</div>
											</div>
										</div>
									<?php
									// ============================== BUTTON UPDATE CLICK ==========================================================
									$btnUpdateIdUser = "updateItemButton".$iditem;
									if(isset($_POST[$btnUpdateIdUser])){
										$idinventory	= "idinventory".$iditem;
										$category 		= "category".$iditem;
										$name 			= "name".$iditem;
										$serialNumber 	= "serialNumber".$iditem;
										$dateIn 		= "dateIn".$iditem;
										$iditem 		= "hiddeniditem".$iditem;

										$postidinventory 	= $_POST[$idinventory];
										$postdateIn			= date('Y-m-d 00:00:00', strtotime(str_replace(',', '', $_POST[$dateIn])));
										$postname 			= $_POST[$name];
										$postcategory 		= $_POST[$category];
										$postserialNumber 	= $_POST[$serialNumber];
										$postiditem 		= $_POST[$iditem];

										$updateItemQry = "UPDATE item SET
															idinventory = '".$postidinventory."',
															dateIn = '".$postdateIn."',
															name = '".$postname."',
															idcategory = '".$postcategory."',
															serialNumber = '".$postserialNumber."'
															WHERE iditem = '".$postiditem."'";
									// ================================== LOGGING
										$logItemQry = "";
										$logItemQry = "SELECT * FROM item WHERE iditem = '".$postiditem."' LIMIT 1";
										if($resultLogItem = mysql_query($logItemQry)){
											if (mysql_num_rows($resultLogItem) > 0) {
												$rowLogItem = mysql_fetch_array($resultLogItem);
												$rowidinventory 	= $rowLogItem['idinventory'];
												$rowdateIn 			= $rowLogItem['dateIn'];
												$rowdateOut 		= $rowLogItem['dateOut'];
												$rowname 			= $rowLogItem['name'];
												$rowcategory 		= $rowLogItem['idcategory'];
												$rowserialNumber 	= $rowLogItem['serialNumber'];
												$rowstatus 			= $rowLogItem['status'];
												$rowiduser 			= $rowLogItem['iduser'];
												$rowlastIdUser 		= $rowLogItem['lastIdUser'];
												$rownotes 			= $rowLogItem['notes'];

												$catQry = "";
											    $catQry = "SELECT name FROM category WHERE idcategory = '".$rowcategory."' LIMIT 1";
											    if($resultCatr = mysql_query($catQry)){
											        if (mysql_num_rows($resultCatr) > 0) {
											            $rowCat = mysql_fetch_array($resultCatr);
											            $category = $rowCat['name'];
											        }else{
											            $category = "Not Found";
											        }
											    }

											    $catQry = "";
											    $catQry = "SELECT name FROM category WHERE idcategory = '".$postcategory."' LIMIT 1";
											    if($resultCatr = mysql_query($catQry)){
											        if (mysql_num_rows($resultCatr) > 0) {
											            $rowCat = mysql_fetch_array($resultCatr);
											            $categoryPost = $rowCat['name'];
											        }else{
											            $categoryPost = "Not Found";
											        }
											    }

											    $logUserQry = "";
							                    $logUserQry = "SELECT user.name as name, division.name as division FROM user,division WHERE user.iduser = '".$rowiduser."' AND user.iddivision = division.iddivision LIMIT 1";
							                    if($resultLogUser = mysql_query($logUserQry)){
							                        if (mysql_num_rows($resultLogUser) > 0) {
							                            $rowLogUser = mysql_fetch_array($resultLogUser);
							                            $name           = $rowLogUser['name'];
							                            $division     = $rowLogUser['division'];
							                        }
							                    }

												$loggingText = "
												 				OLD DATA
												 				---------------------------------------
												 				ID Inventory 	: ".$rowidinventory."
							                    				Date In 		: ".$rowdateIn."
							                    				Date Out 		: ".$rowdateOut."
							                    				Item Name 		: ".$rowname."
							                    				Category 		: ".$category."
							                    				S/N 			: ".$rowserialNumber."
							                    				Status 			: ".$rowstatus."
							                    				User 			: ".$name." - ".$division."
							                    				Last ID User 	: ".$rowlastIdUser."
							                    				Notes 			: ".$rownotes."

							                    				NEW DATA
							                    				----------------------------------------
							                    				ID Inventory 	: ".$postidinventory."
							                    				Date In 		: ".$postdateIn."
							                    				Item Name 		: ".$postname."
							                    				Category 		: ".$categoryPost."
							                    				S/N 			: ".$postserialNumber."
							                    				";
											}
										}
											echo $updateItemQry;
										// ================================== LOGGING
										if(mysql_query($updateItemQry)){
											logging($now, $user, "Update Item", $loggingText, $postiditem);
									        header('Location: ./index.php?menu=item');
									    }else{
									    	echo "ERROR: Could not able to execute ".$updateItemQry.". " . mysql_error($conn);
									    }
									}
								}
							}
						}
					?>
				</tbody>
			</table>
			<div id="modalDelItem" class="modal">
				<div class="modal-content">
					<h4>Deleting Confirmation</h4>
					<h5>Are you sure you want to delete selected item(s) ?</h5>
				</div>
				<div class="modal-footer col s12 mb-10">
					<button type="submit" name="btnDeleteItem" class="mr-10 waves-effect waves-light btn red darken-4 right">Yes</button>
					<a href="#!" class="ml-10 mr-10 modal-action modal-close waves-effect waves-light btn blue darken-4 right">Cancel</a>
				</div>
			</div>
		</form>
		<div id="modalAddItem" class="modal">
			<div class="modal-content">
				<div class="border-bottom mb-10"><h4>Add New Item</h4></div>
				<div class="col s12 mt-30 center container">
					<form action="#" method="post" enctype="multipart/form-data">
						<div class="file-field input-field col s12 m6 l6">
							<input id="addIdInventory" name="addIdInventory" type="text" class="validate" required>
							<label for="addIdInventory">ID Inventory</label>
						</div>
						<div class="input-field col s12 m6 l6">
							<select id="addItemsCategory" name="addItemsCategory" required>
								<option value="" disabled selected>Pilih Jenis Item</option>
								<?php
									$catQry = "";
									$catQry = "SELECT idcategory, name FROM category ORDER BY name ASC";
									if($resultCat = mysql_query($catQry)){
										if (mysql_num_rows($resultCat) > 0) {
											while ($rowCat = mysql_fetch_array($resultCat)) {
												$idcategoryUpdate 	= $rowCat['idcategory'];
												$nameUpdate 		= $rowCat['name'];
												?>
													<option value="<?php echo $idcategoryUpdate; ?>"><?php echo $nameUpdate; ?></option>
												<?php
											}
										}
									}
								?>
							</select>
							<label>Jenis Item</label>
						</div>
						<div class="file-field input-field col s12 m6 l6">
							<input id="addItemName" name="addItemName" type="text" class="validate" required>
							<label for="addItemName">Nama</label>
						</div>
						<div class="file-field input-field col s12 m6 l6">
							<input id="addItemSN" name="addItemSN" type="text" class="validate" required>
							<label for="addItemSN">Serial Number</label>
						</div>
						<div class="input-field col s12 m6 l6">
							<select id="addItemsUser" name="addItemsUser">
								<option value="" disabled selected>Pilih User</option>
								<?php
									$userQry = "";
									$userQry = "SELECT user.iduser as userid, user.name as nameUser, division.name as division FROM user, division WHERE user.iddivision = division.iddivision ORDER BY user.name ASC";
									if($resultUser = mysql_query($userQry)){
										if (mysql_num_rows($resultUser) > 0) {
											while ($rowUser = mysql_fetch_array($resultUser)) {
												$iduserUpdate 		= $rowUser['userid'];
												$nameUserUpdate 		= $rowUser['nameUser'];
												$divisionUpdate 	= $rowUser['division'];
												?>
													<option value="<?php echo $iduserUpdate; ?>"><?php echo $nameUserUpdate." - ".$divisionUpdate; ?></option>
												<?php
											}
										}
									}
								?>
							</select>
							<label>Untuk User</label>
						</div>
						<div class="input-field col s12 mb-20">
							<button type="submit" name="addItemButton" class="waves-effect waves-light btn green darken-4 right">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="modalConfirmation" class="modal">
			<div class="modal-content">
				<h5>Kembalikan Item Ke-Stock Untuk Menghapus Item..</h5>
			</div>
			<div class="modal-footer col s12 mb-10">
				<a href="#!" class="mr-10 waves-effect modal-action modal-close waves-light btn green darken-4 right">Yes</a>
			</div>
		</div>
	</div>
</div>