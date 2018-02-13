<?php
//======================================================================
// FAQs
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
$section_template_class = 'faq';
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
// FAQ | Show FAQs
//-----------------------------------------------------
if ($show == 'on'){ 
	$themo_faqs = get_post_meta($post->ID, $key, array());
	// Animation
	$themo_enable_animate = get_post_meta($post->ID, $key.'_animate', true );
	$themo_animation_style = get_post_meta($post->ID, $key.'_animate_style', true );

	if (!empty( $themo_faqs ) ) {
?>
		<div class="row">
            <dl class="mobile-faq col-xs-12">
            <?php
            $i = 0;
                foreach( $themo_faqs as $row ) {                    
                    foreach($row as $value => $element){ 
						if ($element['title'] > ''){ ?>
                            <dt class="faq-dt-<?php echo $i; ?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .faq-dt-'.$i); ?>"><?php echo $element['title']; ?></dt>
                        <?php }
                        if ($element['answer'] > ''){ ?>
                            
                            <dd class="faq-dd-<?php echo $i; ?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .faq-dd-'.$i); ?>"><?php echo themo_content($element['answer']); ?></dd>
                        <?php } ?>
                                    
                     <?php
                    $i++;
                    } // end inner loop
                } // end outer loop ?>
            </dl> <!-- /.mobile-faq --> 
		</div> <!-- /.row -->  
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


