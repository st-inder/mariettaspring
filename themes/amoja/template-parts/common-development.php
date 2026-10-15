<?php
/**
 * Theme functions and definitions.
 */
		 
	 
		 
function author_contributor_box_shortcode() {
    if ( ! is_singular( array( 'post', 'page' ) ) ) return '';

    global $post;
    $author_id = $post->post_author;

    // Written by (Post Author)
    $author_name  = get_the_author_meta( 'display_name', $author_id );
    $author_date = get_post_time( 'F j, Y', false, $post->ID, true );
	 $author_image  = get_field('profile_image', 'user_' . $author_id);

    // Custom fields
    $need_review22  = get_field( 'medically_reviewed_need', $post->ID );
    $doctor_id    = get_field( 'doctor_select', $post->ID );
    $review_date  = get_field( 'reviewed_date', $post->ID );
    ob_start();
    ?>
    <div class="author-contributor-sec">
        <div id="top-stats">
            
            <?php 
		if ($need_review22) : 
                $doctor_name = get_the_author_meta( 'display_name', $doctor_id );
                $doctor_img  = get_field('profile_image',  'user_' . $doctor_id);
                ?>
                <div class="one-stat">
                    <div class="os-split">
                        <div class="img-sec">
                            <img src="<?php echo esc_url($doctor_img['url']); ?>" alt="<?php echo esc_attr( $doctor_name ); ?>" class="img-fluid">
                        </div>
                        <div class="content-box">
                            <p class="one-stat-title">Medically Reviewed By</p>
                            <p class="os-name">
                                <a href="<?php echo esc_url( get_author_posts_url( $doctor_id ) ); ?>">
                                    <?php echo esc_html( $doctor_name ); ?>
                                </a>
                            </p>
                           
                                <p class="os-date">On <?php echo esc_html( $review_date ); ?></p>
                            
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="one-stat">
                <div class="os-split">
                    <div class="img-sec">
                        <img src="<?php echo esc_url($author_image['url']); ?>" alt="<?php echo esc_attr( $author_name ); ?>" class="img-fluid">
                    </div>
                    <div class="content-box">
                        <p class="one-stat-title">Written By</p>
                        <p class="os-name">
                            <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>">
                                <?php echo esc_html( $author_name ); ?>
                            </a>
                        </p>
                        <p class="os-date">On <?php echo esc_html( $author_date ); ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'author_contributor_box', 'author_contributor_box_shortcode' );





function learn_tab_shortcode() {
    ob_start();

    // Get heading field
    $heading = get_field('learn_tab_heading');

    if( have_rows('learn_tab') ): ?>


<div class="elementor-element elementor-element-4d05a0d e-con-full key-point-sec e-flex e-con e-child" data-id="4d05a0d" data-element_type="container">
<?php if ( $heading ): ?>
   <div class="elementor-element elementor-element-ab31266 elementor-widget elementor-widget-heading" data-id="ab31266" data-element_type="widget" data-widget_type="heading.default">
      <h3 class="elementor-heading-title elementor-size-default"><?php echo esc_html($heading); ?></h3>
   </div>
<?php endif; ?>

   <div class="elementor-element elementor-element-f34e2ea elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="f34e2ea" data-element_type="widget" data-widget_type="icon-list.default">
      <ul class="elementor-icon-list-items">
	  <?php while( have_rows('learn_tab') ): the_row(); 
                    $point = get_sub_field('learn_list'); ?>
                    <?php if ($point): ?>
         <li class="elementor-icon-list-item">
            <span class="elementor-icon-list-icon">
               <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                  <path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path>
               </svg>
            </span>
            <span class="elementor-icon-list-text"><?php echo esc_html($point); ?></span>
         </li>
		                     <?php endif; ?>
                <?php endwhile; ?>
         
      </ul>
   </div>
</div>
    <?php endif;

    return ob_get_clean();
}
add_shortcode('learn_tab_keypoints', 'learn_tab_shortcode');







// Function to display author details in sidebar with custom HTML
function get_custom_author_sidebar_html($post_id) {
    // Get post author ID
    $author_id = get_post_field('post_author', $post_id);
    if (!$author_id) return '';

    // Get WP author object
    $author = get_user_by('ID', $author_id);
    if (!$author) return '';

    // Default WP author fields
    $author_name  = $author->display_name;

    // ACF custom fields
    $author_title  = get_field('position', 'user_' . $author_id); // e.g. Medical Content Writer
    $author_image  = get_field('profile_image', 'user_' . $author_id);
    $author_url    = get_author_posts_url( $author_id );
    $author_bio    = get_field('short_bio', 'user_' . $author_id);
    $linkedin_url  = get_field('linkedin', 'user_' . $author_id);
    $website_url   = get_field('website_name', 'user_' . $author_id);

    // Start HTML
    ob_start(); ?>
    
    <div class="author-bio-sidebar-sec">
        <div id="author-bio">
            <div class="span_12">
                <?php if (!empty($author_image['url'])): ?>
                    <img src="<?php echo esc_url($author_image['url']); ?>" alt="<?php echo esc_attr($author_name); ?>" />
                <?php endif; ?>

                <div id="author-info">
                    <h3>
                        <?php if (!empty($author_url)): ?>
                            <a href="<?php echo esc_url($author_url); ?>"><?php echo esc_html($author_name); ?></a>
                        <?php else: ?>
                            <?php echo esc_html($author_name); ?>
                        <?php endif; ?>
                    </h3>

                    <?php if (!empty($author_title)): ?>
                        <h4><span><?php echo esc_html($author_title); ?></span></h4>
                    <?php endif; ?>

                    <div class="socialicon">
                        <?php if (!empty($website_url)): ?>
                            <a href="<?php echo esc_url($website_url); ?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="18px" height="18px">
                                <path  style="fill:#77A6AE;" d="M 25 1.0507812 C 24.7825 1.0507812 24.565859 1.1197656 24.380859 1.2597656 L 1.3808594 19.210938 C 0.95085938 19.550938 0.8709375 20.179141 1.2109375 20.619141 C 1.5509375 21.049141 2.1791406 21.129062 2.6191406 20.789062 L 4 19.710938 L 4 46 C 4 46.55 4.45 47 5 47 L 19 47 L 19 29 L 31 29 L 31 47 L 45 47 C 45.55 47 46 46.55 46 46 L 46 19.710938 L 47.380859 20.789062 C 47.570859 20.929063 47.78 21 48 21 C 48.3 21 48.589063 20.869141 48.789062 20.619141 C 49.129063 20.179141 49.049141 19.550938 48.619141 19.210938 L 25.619141 1.2597656 C 25.434141 1.1197656 25.2175 1.0507812 25 1.0507812 z M 35 5 L 35 6.0507812 L 41 10.730469 L 41 5 L 35 5 z"/>
                             </svg></a>
                        <?php endif; ?>
                        <?php if (!empty($linkedin_url)): ?>
                            <a href="<?php echo esc_url($linkedin_url); ?>" target="_blank"> <svg height="18px" width="18px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                viewBox="0 0 382 382" xml:space="preserve">
                                <path style="fill:#77A6AE;" d="M347.445,0H34.555C15.471,0,0,15.471,0,34.555v312.889C0,366.529,15.471,382,34.555,382h312.889
                                   C366.529,382,382,366.529,382,347.444V34.555C382,15.471,366.529,0,347.445,0z M118.207,329.844c0,5.554-4.502,10.056-10.056,10.056
                                   H65.345c-5.554,0-10.056-4.502-10.056-10.056V150.403c0-5.554,4.502-10.056,10.056-10.056h42.806
                                   c5.554,0,10.056,4.502,10.056,10.056V329.844z M86.748,123.432c-22.459,0-40.666-18.207-40.666-40.666S64.289,42.1,86.748,42.1
                                   s40.666,18.207,40.666,40.666S109.208,123.432,86.748,123.432z M341.91,330.654c0,5.106-4.14,9.246-9.246,9.246H286.73
                                   c-5.106,0-9.246-4.14-9.246-9.246v-84.168c0-12.556,3.683-55.021-32.813-55.021c-28.309,0-34.051,29.066-35.204,42.11v97.079
                                   c0,5.106-4.139,9.246-9.246,9.246h-44.426c-5.106,0-9.246-4.14-9.246-9.246V149.593c0-5.106,4.14-9.246,9.246-9.246h44.426
                                   c5.106,0,9.246,4.14,9.246,9.246v15.655c10.497-15.753,26.097-27.912,59.312-27.912c73.552,0,73.131,68.716,73.131,106.472
                                   L341.91,330.654L341.91,330.654z"/>
                             </svg></a>
                        <?php endif; ?>
                    </div>

                    <div class="clear"></div>

                    <?php if (!empty($author_bio)): ?>
                        <p><?php echo $author_bio; ?></p>
                    <?php endif; ?>

                    <?php if (!empty($author_url)): ?>
                        <div class="button-container form-button bio-read-more">
                            <a class="elementor-author-box__button elementor-button elementor-size-xs" href="<?php echo esc_url($author_url); ?>">Read More</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    return ob_get_clean();
}

// Shortcode for sidebar author box
function custom_sidebar_author_shortcode_html($atts) {
    $post_id = get_the_ID();
    return get_custom_author_sidebar_html($post_id);
}
add_shortcode('custom_sidebar_author', 'custom_sidebar_author_shortcode_html');


// Function to display Faq 
function acf_faq_accordion_shortcode() {
if( have_rows('faq_section') ):
ob_start(); ?>
<div class="elementor-element elementor-element-74f0d1a e-con-full elementor-hidden-laptop elementor-hidden-tablet_extra elementor-hidden-tablet elementor-hidden-mobile_extra elementor-hidden-mobile e-flex e-con e-child " data-id="74f0d1a" data-element_type="container" data-e-type="container">
   <div class="elementor-element elementor-element-7f7cab8 elementor-hidden-tablet sp_faq_sec elementor-hidden-mobile_extra elementor-hidden-mobile elementor-widget__width-initial elementor-widget elementor-widget-bdt-accordion" data-id="7f7cab8" data-element_type="widget" data-e-type="widget" data-widget_type="bdt-accordion.default">
      <div class="bdt-ep-accordion-container">
         <div id="bdt-ep-accordion-7f7cab8" class="bdt-ep-accordion bdt-accordion" data-bdt-accordion="{&quot;collapsible&quot;:true,&quot;multiple&quot;:false,&quot;transition&quot;:&quot;ease-in-out&quot;}" data-settings="{&quot;id&quot;:&quot;bdt-ep-accordion-7f7cab8&quot;,&quot;activeHash&quot;:&quot;no&quot;,&quot;activeScrollspy&quot;:null,&quot;hashTopOffset&quot;:false,&quot;hashScrollspyTime&quot;:false,&quot;closeAllItemsOnMobile&quot;:false}">
            <?php $i = 1; while( have_rows('faq_section') ): the_row(); 
               $question = get_sub_field('faq_sectionheading');
               $answer   = get_sub_field('faq_sectioncontent');
               ?>
            <div class="bdt-ep-accordion-item">
               <div class="bdt-ep-accordion-title bdt-accordion-title bdt-flex bdt-flex-middle bdt-flex-between" id="bdt-ep-accordion-how-much-does-sober-living-cost-in-georgia" data-accordion-index="<?php echo $i; ?>"  aria-controls="bdt-accordion-1" aria-expanded="false" aria-disabled="false">
                  <span class="bdt-ep-accordion-icon bdt-flex-align-right" aria-hidden="true">
                     <span class="bdt-ep-accordion-icon-closed">
                        <svg aria-hidden="true" class="fa-fw e-font-icon-svg e-fas-angle-down" viewBox="0 0 320 512" xmlns="http://www.w3.org/2000/svg">
                           <path d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z"></path>
                        </svg>
                     </span>
                     
                  </span>
                  <span role="heading" class="bdt-ep-title-text bdt-flex-inline bdt-flex-middle">
                  <?php echo esc_html($question); ?>				</span>
               </div>
               <div class="bdt-ep-accordion-content bdt-accordion-content" hidden="" id="bdt-accordion-1" role="region" aria-labelledby="bdt-ep-accordion-how-much-does-sober-living-cost-in-georgia">
                  <?php echo wp_kses_post($answer); ?>					
               </div>
            </div>
            <?php $i++; endwhile; ?>	
         </div>
      </div>
   </div>
</div>
<?php
        return ob_get_clean();
    else:
        return '<p>No FAQs added yet.</p>';
    endif;
}
add_shortcode('acf_faq_accordion', 'acf_faq_accordion_shortcode');


function code_our_teams()
{
	ob_start();
	

    // Get all authors
    $authors = get_users( array(
        'role__in'   => array('author', 'contributor'),
        'meta_key'   => 'author_order',
        'meta_query' => array(
            array(
                'key'     => 'author_order',
                'value'   => '',
                'compare' => '!=' 
            )
        ),
        'orderby' => array( 
            'meta_value' => 'ASC',
        ),
    ));
	
echo '<section class="contributor-box">';

foreach($authors as $author) {
        $jobrole       = get_the_author_meta('position', $author->ID );
        $authororder   = get_the_author_meta('author_order', $author->ID );
        $user_type = get_field('user_type', 'user_' .  $author->ID);
		
		$medical_r_type = get_field('medical_reviewr', 'user_' .   $author->ID);
        $avatar_url    = get_avatar_url($author->ID, ['size' => 600]);
        $profile_image = get_field('profile_image', 'user_' . $author->ID);

        // Prefer ACF image if available
        $img_url = '';
        if( $profile_image && isset($profile_image['url']) ) {
            $img_url = esc_url($profile_image['url']);
        } else {
            $img_url = esc_url($avatar_url);
        }
        ?>

        <?php if ($user_type == 'contributor') : ?>
         <div class="contributor-col order-<?php echo esc_attr($authororder); ?>">
            <a href="<?php echo esc_url( get_author_posts_url( $author->ID ) ); ?>">
               <div class="contributor-img">
                     <img fetchpriority="high" decoding="async" width="500" height="500" src="<?php echo $img_url; ?>" class="avatar avatar-600 photo" alt="" >
               </div>
               <div class="contributor-content">
                  <div class="contributor-displayname">
                     <?php echo esc_html($author->display_name); ?>			  
                  </div>
				  <?php if ($jobrole) : ?>
                  <div class="contributor-role"><?php echo esc_html($jobrole); ?></div> <?php endif; ?>
               </div>
                  <div class="read-button">
            <span class="button-text">Read More</span>
            </div>
           
            </a>
         </div>
		 <?php endif; ?>
        <?php
    }
    echo '</section>';

    return ob_get_clean();
} 
add_shortcode('contributor','code_our_teams');




function code_our_team_shortcode()
{
	ob_start();
	

    // Get all authors
    $authors = get_users( array(
        'role__in'   => array('author', 'contributor'),
        'meta_key'   => 'author_order',
        'meta_query' => array(
            array(
                'key'     => 'author_order',
                'value'   => '',
                'compare' => '!=' 
            )
        ),
        'orderby' => array( 
            'meta_value' => 'ASC',
        ),
    ));
	
echo '<section class="contributor-box">';

foreach($authors as $author) {
        $jobrole       = get_the_author_meta('position', $author->ID );
        $authororder   = get_the_author_meta('author_order', $author->ID );
         $category_administrative = get_field('user_type', 'user_' .  $author->ID);
	 
		
		$medical_r_type = get_field('medical_reviewr', 'user_' .   $author->ID);
        $avatar_url    = get_avatar_url($author->ID, ['size' => 600]);
        $profile_image = get_field('profile_image', 'user_' . $author->ID);

        // Prefer ACF image if available
        $img_url = '';
        if( $profile_image && isset($profile_image['url']) ) {
            $img_url = esc_url($profile_image['url']);
        } else {
            $img_url = esc_url($avatar_url);
        }
        ?>

        <?php if ($category_administrative == 'team') : ?>
         <div class="contributor-col order-<?php echo esc_attr($authororder); ?>">
            <a href="<?php echo esc_url( get_author_posts_url( $author->ID ) ); ?>">
               <div class="contributor-img">
                     <img fetchpriority="high" decoding="async" width="500" height="500" src="<?php echo $img_url; ?>" class="avatar avatar-600 photo" alt="" >
               </div>
               <div class="contributor-content">
                  <div class="contributor-displayname">
                     <?php echo esc_html($author->display_name); ?>			  
                  </div>
				  <?php if ($jobrole) : ?>
                  <div class="contributor-role"><?php echo esc_html($jobrole); ?></div> <?php endif; ?>
               </div>
                  <div class="read-button">
            <span class="button-text">Read More</span>
            </div>
           
            </a>
         </div>
		 <?php endif; ?>
        <?php
    }
    echo '</section>';

    return ob_get_clean();
} 
add_shortcode('team_user','code_our_team_shortcode');





function code_medical_review()
{
	ob_start();
	

    // Get all authors
    $authors = get_users( array(
        'role__in'   => array('author','contributor'),
        
        'orderby' => array( 
            'meta_value' => 'ASC',
        ),
    ));
	
echo '';

foreach($authors as $author) {
        $medical_reviewr       = get_the_author_meta('medical_reviewr', $author->ID );
       
       
        ?>

        <?php if ($medical_reviewr == '1') : ?>
		<div class="elementor-element elementor-element-eaeea88 medical-review-btn elementor-widget elementor-widget-text-editor" data-id="eaeea88" data-element_type="widget" data-e-type="widget" data-widget_type="text-editor.default">
		<svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg" <g="" clip-path="url(#clip0_599_224)">
                                                        <path d="M7.4238 2.38461C5.74106 3.77268 3.83615 4.60361 1.6479 4.80953C1.6479 4.86985 1.6479 4.92554 1.6479 4.98122C1.64732 6.59552 1.65341 8.20981 1.64412 9.82411C1.63281 11.8357 2.35034 13.5608 3.68824 15.0371C4.67462 16.1255 5.88433 16.8697 7.29734 17.2775C7.37507 17.2999 7.47049 17.2996 7.54851 17.2775C10.3661 16.4765 12.5451 14.0951 13.093 11.2252C13.2107 10.6086 13.2374 9.9842 13.1988 9.36238C13.1713 8.91922 13.289 8.57119 13.5817 8.23592C13.9941 7.76346 14.361 7.25127 14.7476 6.75619C14.7705 6.7269 14.7963 6.70022 14.8378 6.65323C14.8421 6.71211 14.8471 6.74778 14.8471 6.78346C14.8476 7.87106 14.856 8.95866 14.8465 10.046C14.8288 12.0753 14.1539 13.8804 12.9314 15.4828C11.597 17.2317 9.86699 18.4002 7.73151 18.9597C7.51834 19.0157 7.32171 19.0128 7.1097 18.9577C3.64155 18.0568 0.944288 15.2528 0.184416 11.7502C0.0611538 11.1814 0.000828074 10.6049 0.000248019 10.0236C-0.000912092 7.79536 0.00227821 5.56737 0.00401838 3.33909C0.00401838 3.28746 0.00401838 3.23555 0.00401838 3.16362C2.99971 3.32082 5.478 2.29209 7.43772 0C7.98036 0.699257 8.62422 1.2825 9.36524 1.75902C10.101 2.23205 10.8844 2.60039 11.7429 2.85213C11.5283 3.13056 11.3235 3.3968 11.1179 3.66218C10.9906 3.82633 10.8569 3.98585 10.7353 4.15407C10.6794 4.23208 10.6283 4.24078 10.543 4.2083C9.5381 3.82633 8.60885 3.3098 7.75878 2.65143C7.64799 2.56558 7.53981 2.47713 7.42351 2.38432L7.4238 2.38461Z" fill="#F9BA96"></path>
                                                        <path d="M8.03891 9.31429C8.43334 8.8079 8.81589 8.31659 9.19902 7.82558C10.5363 6.11209 11.8739 4.39861 13.2113 2.68513C13.3241 2.5404 13.4349 2.39394 13.55 2.25124C13.7159 2.0459 13.9708 2.00936 14.1805 2.16743C14.6469 2.51952 15.1115 2.87422 15.5735 3.23241C15.8018 3.40932 15.8215 3.66513 15.6324 3.90788C14.8018 4.97489 13.9685 6.04046 13.139 7.10863C12.2681 8.23016 11.3992 9.35315 10.5317 10.477C9.93569 11.2494 9.34316 12.0243 8.74918 12.7981C8.53717 13.0742 8.32255 13.0974 8.06414 12.8712C6.5238 11.5223 4.98347 10.1731 3.44313 8.82443C3.19428 8.60662 3.18094 8.40128 3.40426 8.15418C3.78971 7.72784 4.17632 7.30237 4.56322 6.8769C4.77581 6.64284 4.9765 6.63095 5.21549 6.84035C6.11312 7.62662 7.00989 8.41346 7.90694 9.20031C7.94668 9.23511 7.98641 9.26933 8.03862 9.31487L8.03891 9.31429Z" fill="#F9BA96"></path>
                                                    
                                                    <defs>
                                                        <clipPath id="clip0_599_224">
                                                            <rect width="15.761" height="19" fill="#000"></rect>
                                                        </clipPath>
                                                    </defs>
                                                </svg>
									<span>Medical Reviewer</span>								
		</div>
      
		 <?php endif; ?>
        <?php
    }
    echo '';

    return ob_get_clean();
} 
add_shortcode('medical_review','code_medical_review');



function team_breadcrumb_shortcode()
{
	ob_start();
	

    // Get all authors
    $authors = get_users( array(
        'role__in'   => array('author','contributor'),
        'meta_key'   => 'author_order',
        'meta_query' => array(
            array(
                'key'     => 'author_order',
                'value'   => '',
                'compare' => '!=' 
            )
        ),
        'orderby' => array( 
            'meta_value' => 'ASC',
        ),
    ));
	
echo '';

foreach($authors as $author) {
		
		$firstname = get_field('first_name', 'user_' . $author->ID);
		$p_section = get_field('user_type', 'user_' . $author->ID);
		$last_name = get_field('last_name', 'user_' . $author->ID);
		  
       
        ?>
<?php if ($author) : ?>
			<div class=" breadcrumb custom-breadcrumb" id="breadcrumbs">
			   <span>
			   <span><a href="<?php bloginfo( 'url' ); ?>">Home</a></span> /
			   <?php if($p_section == 'contributor') { ?> 
			   <span><a href="<?php echo esc_url( get_page_link( 7993 ) ); ?>">Our Contributors</a></span> / 
			   <?php } else { ?> 
			   <span><a href="<?php echo esc_url( get_page_link( 7983 ) ); ?>">Meet Our Team</a></span> / 
			   <?php } ?> 
			   <span class="breadcrumb_last" aria-current="page"><?php echo $firstname; ?> <?php echo $last_name; ?></span>
			   </span>
			</div>
   <?php endif; ?>
        <?php
    }
    echo '';

    return ob_get_clean();
} 
add_shortcode('team_breadcrumb', 'team_breadcrumb_shortcode');


function custom_author_slug() {
    global $wp_rewrite;
    $wp_rewrite->author_base = 'contributors'; // change "author" to "contributors"
    $wp_rewrite->flush_rules();
}
add_action('init', 'custom_author_slug');



function google_review_shortcode() {
    ob_start();

    // Get heading field
        $reviews_count = get_field('google_review_count', 'option');
        $reviews_rating = get_field('google_review_rating', 'option');
        $reviews_link = get_field('google_review_link', 'option');
        $logos = get_field('google_review', 'option');

     ?>
        
        
<div class="elementor-widget-container lqd-unit-animation-done" style="">
   <div class="page-container page-container--bottom">
      <div class="google-reviews">
         <a class="google-reviews__link" href="<?php echo $reviews_link; ?>" target="_blank">
            <div class="google-reviews__label">
               <b><?php echo $reviews_rating ;?></b> Google Reviews                
            </div>
            <div class="google-reviews__list">
               <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none" id="svg-replaced-3" class="style-svg replaced-svg svg-replaced-3">
                  <path d="M8.21101 0L10.0859 6.21885H16.153L11.2446 10.0623L13.1194 16.2812L8.21101 12.4377L3.30262 16.2812L5.17746 10.0623L0.269062 6.21885H6.33617L8.21101 0Z" fill="#fbbc04"></path>
               </svg>
               <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none" id="svg-replaced-4" class="style-svg replaced-svg svg-replaced-4">
                  <path d="M8.21101 0L10.0859 6.21885H16.153L11.2446 10.0623L13.1194 16.2812L8.21101 12.4377L3.30262 16.2812L5.17746 10.0623L0.269062 6.21885H6.33617L8.21101 0Z" fill="#fbbc04"></path>
               </svg>
               <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none" id="svg-replaced-5" class="style-svg replaced-svg svg-replaced-5">
                  <path d="M8.21101 0L10.0859 6.21885H16.153L11.2446 10.0623L13.1194 16.2812L8.21101 12.4377L3.30262 16.2812L5.17746 10.0623L0.269062 6.21885H6.33617L8.21101 0Z" fill="#fbbc04"></path>
               </svg>
               <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none" id="svg-replaced-6" class="style-svg replaced-svg svg-replaced-6">
                  <path d="M8.21101 0L10.0859 6.21885H16.153L11.2446 10.0623L13.1194 16.2812L8.21101 12.4377L3.30262 16.2812L5.17746 10.0623L0.269062 6.21885H6.33617L8.21101 0Z" fill="#fbbc04"></path>
               </svg>
               <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none" id="svg-replaced-7" class="style-svg replaced-svg svg-replaced-7">
                  <defs>
                     <linearGradient id="grad">
                        <stop offset="100%" stop-color="#fbbc04"></stop>
                        <stop offset="0%" stop-color="grey"></stop>
                     </linearGradient>
                  </defs>
                  <path fill="url(#grad)" d="M8.21101 0L10.0859 6.21885H16.153L11.2446 10.0623L13.1194 16.2812L8.21101 12.4377L3.30262 16.2812L5.17746 10.0623L0.269062 6.21885H6.33617L8.21101 0Z"></path>
               </svg>
               <span style="width: 100%;"></span>
            </div>
            <div class="google-reviews__bottom">
               <div class="google-reviews__num">
                  <?php echo $reviews_count ;?>                    
               </div>
                <div class="satisfy-client-images">
                
                <?php if (!empty($logos) && is_array($logos)) : ?>
    <?php foreach ($logos as $logo) :
        $logo_image = $logo['google_review_image'] ?? '';
    ?>
        <div class="satisfy-client-image">
            <figure class="image-anime">
                <?php if ($logo_image) : ?>
                    <img src="<?php echo esc_url($logo_image); ?>" alt="">
                <?php endif; ?>
            </figure>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
                    
                </div>
            </div>
         </a>
      </div>
   </div>
   
</div>

        
            
    <?php 

    return ob_get_clean();
}
add_shortcode('google_review', 'google_review_shortcode');


