<?php
//======================================================================
// TEAM 
//======================================================================
?>

<?php
//-----------------------------------------------------
// GET BACKGROUND
//-----------------------------------------------------
$partName = 'background';
include( locate_template('templates/meta-part-' . $partName . '.php') );
?>

<?php
//-----------------------------------------------------
// GET BORDER
//-----------------------------------------------------
$partName = 'border';
include( locate_template('templates/meta-part-' . $partName . '.php') );
?>


<?php
//-----------------------------------------------------
// Preloader, Section, Container Open
//-----------------------------------------------------
$partName = 'preload-container';
$section_template_class = 'team';
include( locate_template('templates/meta-part-' . $partName . '.php') );
?>


<?php
//-----------------------------------------------------
// Meta Box Header / Subtext
//-----------------------------------------------------
$partName = 'header';
include( locate_template('templates/meta-part-' . $partName . '.php') );
?>

<?php
//-----------------------------------------------------
// Team
//-----------------------------------------------------
if ($show == 'on'){ 
	$team_blocks = get_post_meta($post->ID, $key, array() );
	
	// Animation
	$themo_enable_animate = get_post_meta($post->ID, $key.'_animate', true );
	$themo_animation_style = get_post_meta($post->ID, $key.'_animate_style', true );
	
	if (!empty( $team_blocks ) ) { ?>
	<div class="row">
		<?php
		$i = 0;
		foreach( $team_blocks as $team ) {                    
			foreach($team as $value => $element){ ?>
				<div class="team-member col-md-4 col-sm-6">
					<?php if (isset($element[$key.'_photo']) && $element[$key.'_photo'] > "") { ?>
						<?php $img_src = return_metabox_image($element[$key."_photo"], null, "themo_team", true, $alt); ?>
                        <div class="team-member-image team-member-image-<?php echo $i; ?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .team-member-image-'.$i); ?>"><img class="img-responsive" src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr($alt);?>"></div>
					<?php } ?>
					<h4 class="team-member-title-<?php echo $i; ?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .team-member-title-'.$i); ?>"><?php echo $element['title'] ?></h4>
					<h5 class="team-member-job-title-<?php echo $i; ?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .team-member-job-title-'.$i); ?>"><?php echo $element[$key.'_job_title'] ?></h5>
					<div class="team-member-bio-<?php echo $i; ?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .team-member-bio-'.$i); ?>"><?php echo themo_content($element[$key.'_bio']); ?></div>
                    
					<?php $show_social = false; $show_media_links = '';?>
                    <?php for ($i = 1; $i <= 4; $i++) { ?>
                        <?php if (isset($element[$key.'_social_'.$i.'_name']) && isset($element[$key.'_social_'.$i.'_icon']) && isset($element[$key.'_social_'.$i.'_link']) ){ ?>
                        <?php $show_social = true; ?>
                        <?php 
						$show_media_links .= "<a target='_blank' href='".$element[$key.'_social_'.$i.'_link']."'><i class='soc-icon social ".$element[$key.'_social_'.$i.'_icon']."'></i></a>";
						?>
                        <?php } ?>
                    <?php }?>
                    <?php if($show_social){ ?>
                     <div class="team-member-social team-member-social-<?php echo $i; ?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .team-member-social-'.$i); ?>">
                     	<?php echo $show_media_links; ?>
                     </div>
                    <?php }?>
				</div> 
				<?php 
			$i++;
			} // end inner loop
		} // end outer loop ?>
	</div><!-- /.row -->
	<?php } // end inner if / then ?>
<?php } // end outer if / then  ?>

<?php
//-----------------------------------------------------
// Preloader, Section, Container Close
//-----------------------------------------------------
$partName = 'preload-container-close';
include( locate_template('templates/meta-part-' . $partName . '.php') );
?>

<?php
//-----------------------------------------------------
// GET BORDER CLOSE
//-----------------------------------------------------
$partName = 'border-close';
include( locate_template('templates/meta-part-' . $partName . '.php') );
?>


