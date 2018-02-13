<?php
global $i_panel_count; // To support muultiple accordion meta boxes.
//======================================================================
// Accordion Template Part
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
$section_template_class = 'accordion';
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
// Accordion
//-----------------------------------------------------

if ($show == 'on'){ 
	$accordion = get_post_meta($post->ID, $key, array());
	$random_number = rand(1,99); // Needs random number to support muultiple accordion meta boxes.
	if (!empty( $accordion ) ) {
?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group" id="accordion<?php echo $random_number;?>">
                    <?php
					if(!isset($i_panel_count) && !$i_panel_count > 0){
						$i_panel_count = 1;
					}
                    
                    foreach( $accordion as $accord ) {                    
                        foreach($accord as $value => $element){  
                            $panel_count = convertNumber($i_panel_count);
                            $panel_count = ucwords(strtolower($panel_count));
                            if ($i_panel_count == 1){
                                $first = "in";
                            }else{
                                $first = "";
                            }
                            // ICONS
							$glyphicon = false;
                            if(isset($element[$key.'_glyphicons_icon_set'])){
								if($element[$key.'_glyphicons_icon_set'] > "" && $element[$key.'_glyphicons_icon_set'] != 'none'){
									$glyphicon_class = $element[$key.'_glyphicons_icon_set']." ".$element[$key.'_glyphicons-icon'];
									$glyphicon = true;
								}
							}
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion<?php echo $random_number;?>" href="#collapse<?php echo $panel_count; ?>" class="accordion-toggle"><?php if($glyphicon){ ?> <i class="<?php echo esc_attr($glyphicon_class);?>"></i><?php } ?><?php echo $element['title'] ; ?></a>
                                    </h4>
                                </div>
                                <div id="collapse<?php echo $panel_count; ?>" class="panel-collapse collapse <?php echo $first; ?>"> 
                                    <div class="panel-body">
                                         <?php if(isset($element['title']) && $element['title'] > ""){?><h2 class="accordion-title"><?php echo $element['title']; ?></h2><?php } ?>
                                         <?php echo themo_content($element[$key.'_description']) ; ?>
                                         <?php 
										 $button = do_shortocde_button($element, $key, true); 
										 if ($button > ""){ ?>
											 <p class="accordion-btn"><?php echo do_shortcode($button); ?></p>
										 <?php }
										 ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        $i_panel_count++;
                        } // end inner loop
                    } // end outer loop ?>
                </div> <!-- /.panel-group -->
            </div> <!-- /.col-md-6 -->        
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