<div class="row">
	<div class="container">
		<div class="row">
			<div class="col s12 border-bottom">
				<h3>Cermati Inventory</h3>
				<!-- <hr class="left" style="background:#F87431; border:0; height:7px; width:0,001157407%" /> -->
			</div>
		</div>
		<div class="row">
			<div class="col s12 m6 l6">
				<?php
				$totalUserQry = "";
			    $totalUserQry = "SELECT count(iduser) as totalUser FROM user";
			    if($resultTotalUser = mysql_query($totalUserQry)){
			        if (mysql_num_rows($resultTotalUser) > 0) {
			            $rowTotal = mysql_fetch_array($resultTotalUser);
			            $totalUser = $rowTotal['totalUser'];
			            ?>
							<h5><?php echo "Total User : ".$totalUser." User";?></h5>
			            <?php
			        }
			    }
				?>
			</div>
		</div>
		<div class="row">
			<?php
				$catQry = "";
			    $catQry = "SELECT idcategory, name FROM category ORDER BY idcategory";
			    if($resultCat = mysql_query($catQry)){
			        if (mysql_num_rows($resultCat) > 0) {
			            while($rowCat = mysql_fetch_array($resultCat)){
			            	$idcat 		= $rowCat['idcategory'];
			            	$namecat 	= $rowCat['name'];

			            	$totalCatQry = "";
						    $totalCatQry = "SELECT count(idcategory) as totalCat FROM item WHERE idcategory = '".$idcat."'";
						    if($resultTotalCat = mysql_query($totalCatQry)){
						        if (mysql_num_rows($resultTotalCat) > 0) {
						            $rowTotal = mysql_fetch_array($resultTotalCat);
						            $totalCat = $rowTotal['totalCat'];
						        }
						    }

						    $totalStockQry = "";
						    $totalStockQry = "SELECT count(idcategory) as totalCat FROM item WHERE idcategory = '".$idcat."' AND status = 'Stock'";
						    if($resultTotalStock = mysql_query($totalStockQry)){
						        if (mysql_num_rows($resultTotalStock) > 0) {
						            $rowTotalStock = mysql_fetch_array($resultTotalStock);
						            $totalStock = $rowTotalStock['totalCat'];
						        }
						    }
			            	?>
								<div class="col s12 m6 l6">
									<h5><?php echo "Total ".$namecat." : ".$totalCat." <span class='font-20'>(<a href='#modal".$idcat."' class='modal-trigger'>Stock : ".$totalStock."</a> )</span>";?></h5>
								</div>
								<!-- =========== MODAL -->
								<div id="<?php echo "modal".$idcat; ?>" class="modal">
									<div class="modal-content">
										<div class="row">
											<div class="col s12">
												<h3 class="left-align"><?php echo $namecat; ?></h3>
											</div>
											<div class="col s12">
												<table class="striped responsive-table col s12">
													<thead>
														<!-- =================== to wide screen display -->
														<tr class="hide-on-small-only">
															<th width="5%" data-field="no">
																No.
															</th>
															<th width="5%" data-field="ID">
																ID Inventory
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
														</tr>
													</thead>
													<tbody>
														<?php
														    $idInventoryQry = "";
															$idInventoryQry = "SELECT idcategory, name, serialNUmber, idinventory, status FROM item WHERE status = 'Stock' AND idcategory = '".$idcat."'";
															if($resulIdInventory = mysql_query($idInventoryQry)){
																if (mysql_num_rows($resulIdInventory) > 0) {
																	$no=1;
																	while($rowIdInventory = mysql_fetch_array($resulIdInventory)){
																		$idInventory 	= $rowIdInventory['idinventory'];
																		$name 			= $rowIdInventory['name'];
																		$serialNumber 	= $rowIdInventory['serialNUmber'];
																		$status 		= $rowIdInventory['status'];

																		echo "<tr>";
																		echo "<td>".$no."</td>";
																		echo "<td>".$idInventory."</td>";
																		echo "<td>".$namecat."</td>";
																		echo "<td>".$name."</td>";
																		echo "<td>".$serialNumber."</td>";
																		echo "<td>".$status."</td>";
																		echo "</tr>";
																		$no++;
																	}
																}
															}
														?>
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
			            	<?php
			            }
			        }
			    }
		    ?>
		</div>
	</div>
</div>