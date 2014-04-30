<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

widget_css();

if( $widget_config['forum1'] ) $_bo_table = $widget_config['forum1'];
else $_bo_table = $widget_config['default_forum_id'];

if ( empty($_bo_table) ) jsAlert('Error: empty $_bo_table ? on widget :' . $widget_config['name']);

if( $widget_config['no'] ) $limit = $widget_config['no'];
else $limit = 2;

$list = g::posts( array(
			"bo_table" 	=>	$_bo_table,
			"limit"		=>	$limit,
			"select"	=>	"idx,domain,bo_table,wr_id,wr_parent,wr_is_comment,wr_comment,ca_name,wr_datetime,wr_hit,wr_good,wr_nogood,wr_name,mb_id,wr_subject,wr_content"
				)
		);
		
?>
<div class='gallery_mobile_images_with_captions'>
<?php
	if ( $list ) {	
		foreach( $list as $li ) {			
?>
				<div class='container'>
					<div class='images_with_captions'>
						<div class='caption_image'>					
						<?	
							$_wr_id = $li['wr_id'];
							$imgsrc = x::post_thumbnail($_bo_table, $_wr_id, 378, 128);							
							if ( empty($imgsrc['src']) ) {
								$_wr_content = db::result("SELECT wr_content FROM $g5[write_prefix]$_bo_table WHERE wr_id='$_wr_id'");
								$imgsrc['src'] = x::thumbnail_from_image_tag($_wr_content, $_bo_table, 378, 128);
								if ( empty($imgsrc['src']) ) $imgsrc['src'] = x::url().'/widget/'.$widget_config['name'].'/img/no-image.png';
							}						
							$img = "<img src='$imgsrc[src]'/>";						
							echo "<div class='img-wrapper'><a href='$li[url]'>".$img."</a></div>";
							
							$post_subject = $li['subject'];
														
							$post_content = cut_str( strip_tags($li['wr_content']),"300","..." );							
						?>
						</div>
						<div class='caption'>
							<div class='subject'><a href='<?=$li['url']?>'><?=$post_subject?></a></div>
							<div class='content'><a href='<?=$li['url']?>'><?=$post_content?></a></div>
						</div>	
					</div>					
				</div>		
	<?
		}
	}
	else {
		for ( $i = 0; $i < 2; $i++ ) {?>
			<div class='container <?=$nomargin?>'>
				<div class='images_with_captions'>
						<div class='caption_image'>					
						<? $imgsrc['src'] = $widget_config['url'].'/img/no-image.png';
														
							$img = "<img src='$imgsrc[src]'/>";						
							echo "<div class='img-wrapper'><a href='".url_site_config()."'>".$img."</a></div>";
						?>
						</div>
					<div class='caption'>
						<div class='subject'><a href='<?=url_site_config()?>'>글을 등록해 주세요</a></div>
					</div>						
				</div>
			</div>		
	<?
		}
	}	
?>
	<div style='clear:both'></div>
</div>