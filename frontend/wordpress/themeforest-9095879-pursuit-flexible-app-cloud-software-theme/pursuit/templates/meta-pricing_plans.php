<?php
//======================================================================
// Pricing Plans
//======================================================================

/*
TO DO
*/
//$service_plan_count = themo_convertDigit($service_plan_count);

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
$section_template_class = 'pricing-section';
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
// Pricing Plans
//-----------------------------------------------------
if ($show == 'on'){ 
	$service_plan = get_post_meta($post->ID, $key, array() );
	
	// Animation
	$themo_enable_animate = get_post_meta($post->ID, $key.'_animate', true );
	$themo_animation_style = get_post_meta($post->ID, $key.'_animate_style', true );
		
		if (!empty( $service_plan ) ) { 
			$service_plan_footnote_show = get_post_meta($post->ID, $key.'_footnote_show', true );
			$service_plan_footnote = get_post_meta($post->ID, $key.'_footnote', true );
			
			$service_plan_count = themo_getArrCount($service_plan, 1);	
			$row_class = "";
	
			switch ($service_plan_count) {
				case 1:
					$bootstrap_tier = 'col-sm-6 col-sm-offset-3';
					$service_plan_count = 'one';
					break;
				case 2:
					$bootstrap_tier = 'col-sm-6';
					$service_plan_count = 'two';
					break;
				case 3:
					$bootstrap_tier = 'col-md-4 col-sm-6';
					$service_plan_count = 'three';
					break;
				case 4:
					$bootstrap_tier = 'col-md-3 col-sm-6';
					$service_plan_count = 'four';
					break;
				case 5:
					$bootstrap_tier = 'col-md-2 col-sm-6';
					$service_plan_count = 'five';
					$row_class = $service_plan_count.'-columns';
					break;		
				default:
					$bootstrap_tier = 'col-md-2 col-sm-6';
					$service_plan_count = 'five';
					$row_class = $service_plan_count.'-columns';
				break;
			} ?>	

        <div class="pricing-table <?php echo $service_plan_count; ?>-col">
            <div class="<?php echo $row_class; ?> row">
            <?php
            $i = 0;
            foreach( $service_plan as $col ) {                    
                foreach($col as $value => $element){ 
                    if (++$i == 6) break;
                    if ($element[$key.'_featured'] == 'on'){
                        $highlight_class = 'highlight';
                    }else{
                        $highlight_class = '';
                    }
                ?>
                <div class="pricing-column <?php echo $highlight_class; ?> <?php echo $bootstrap_tier; ?>">
                    <div class="pricing-cost"><?php echo $element[$key.'_price']; ?><span><?php echo $element[$key.'_price_per']; ?></span></div>
                    <div class="pricing-title"><?php echo $element['title']; ?></div>
                    <div class="pricing-features">
                        <?php echo themo_nl2li($element[$key.'_details'],0,1); ?>
                        <?php

                        // check if button is on, else don't fetch animation class
                        $button_show = $element[$key.'_show_button'];
                        if(isset($button_show) && $button_show == 'on'){
                            $animation_class = themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .btn');
                        }
						do_shortocde_button($element, $key, false, $animation_class);
						?>
                    </div>
                </div> <!-- /.pricing-column -->
                <?php
                }
            }
            ?>
            </div> <!-- /.row -->      
            <?php if ($service_plan_footnote_show == 'on' && $service_plan_footnote > ""){ ?>
                <p class="pricing-footer"><?php echo $service_plan_footnote; ?></p>
            <?php } ?>
        </div> <!-- /.pricing-table --> 
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

