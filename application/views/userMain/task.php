					<div class="sidebar_wrapper">
						<div class="sidebar">
							<?php foreach($TASK_DATA['TASK_IMAGES'] as $key => $val): ?>
							<div class="sidebar_item">
								<img onclick="changeImg(this, this.src, <?php echo $val['ID']; ?>)" src="/assets/img/catalog/<?php echo $val['PATH']; ?>.png" alt="<?php echo $val['NAME']; ?>">
								<button class="btn green<?php echo (isset($val['TAGS']) && (count($val['TAGS']) > 0))?' active':''; ?>"><span>&#10004;</span></button>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="user_task_info">
						<div class="user_task_info_photo">
							<div class="info_photo_item">
								<img src="/assets/img/catalog/<?php echo $TASK_DATA['TASK_IMAGES'][0]['PATH']; ?>.png" alt="">
							</div>
						</div>
						<div class="user_task_info_tags">
							<div class="tags_wrapper">
								<?php 
								function tagType($type){
									switch($type){
										case 1:
											return 'location';
										case 2:
											return 'address';
										case 3:
											return 'time';
										case 4:
											return 'date';
										case 5:
											return 'datatime';
										case 6:
											return 'text';
										case 7:
											return 'number';
									}
								}
								foreach($TASK_DATA['TASK_TAGS'] as $key => $val): ?>
								<div class="tag_checkbox">
									<label>
										<span class="tag_type <?php echo tagType($val['VAL_TYPE']); ?>"><?php echo $val['VALUE']; ?></span>
										<input onclick="selectTag(this, <?php echo $val['ID_TAG']; ?>)" value="<?php echo $val['ID_TAG']; ?>" name="TAG<?php echo $key; ?>" type="checkbox" <?php echo (in_array(['ID'=>$val['ID_TAG']], $TASK_DATA['TASK_IMAGES'][0]['TAGS']))?'checked':'' ?>>
										<p class="checkbox_custom">&#10004;</p>
									</label>
								</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<script>
						var IDtask = <?php echo $TASK_DATA['ID']; ?>;
						var CurImageID = <?php echo $TASK_DATA['TASK_IMAGES'][0]['ID_IMAGE']; ?>;
						var data_tasklist = <?php echo json_encode($TASK_DATA['TASK_IMAGES']); ?>;
						var endDateTime = '<?php echo $TASK_DATA['DT_END']; ?>';
					</script>