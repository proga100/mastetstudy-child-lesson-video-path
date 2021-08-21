<?php /* Template Name: Page Home (Custom) */ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IT Stars</title>
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri() . '/assets/css/style.css'; ?>">

    <!-- Font Raleway -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,400;0,500;0,700;0,800;1,500&display=swap" rel="stylesheet">    

    <!-- Font Caveat -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
</head>
<body>

<!-- Header -->
<?php if (get_field('logo')) : ?>
	<header class="header">
	    <div class="container">
	        <div class="header__inner">
		        <a href="index.html" class="logo">
		            <img src="<?php the_field('logo'); ?>" alt="IT Stars">
		        </a>
	            <div class="header__right">
	                <div class="menu">
	                    <?php
	                        wp_nav_menu([
	                            'menu'            => 'landing_menu',
	                            'theme_location'  => 'landing_menu',
	                            'container'       => false,
	                            'container_id'    => '',
	                            'container_class' => '',
	                            'menu_id'         => false,
	                            'menu_class'      => '',
	                            'depth'           => 2,
	                        ]);
	                    ?>
	                </div>
	                <div class="buttons">
	                	<?php if ( !is_user_logged_in() ) : ?>
		                    <a href="<?php echo get_site_url() . '/user-account'; ?>" class="btn btn-primary btn-sm text-uppercase">Log In</a>
		                <?php else: ?>
		                	<div class="dropdown">
		                        <button class="btn btn-primary btn-sm text-uppercase dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                            <span class="icon icon-user mr-2"></span>Log In
		                        </button>
		                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
		                            <a class="dropdown-item" href="<?php echo get_site_url() . '/user-account'; ?>">Account</a>
		                            <a class="dropdown-item text-danger" href="<?php echo wp_logout_url(home_url()); ?>">Logout</a>
		                        </div>
		                    </div>
			            <?php endif; ?>
			            <a href="javascript:;" class="btn btn-primary btn-sm mobile-menu__toggle">
	                        <span></span>
	                        <span></span>
	                        <span></span>
	                    </a>
	                </div>
	            </div>
		    </div>
		</div>
	</header>
<?php endif; ?>

<!-- Main -->
<main class="main">

    <!-- Section - Intro -->
    <?php
    	$section_intro = get_field('intro');
    ?>
    <div class="anchor" id="intro"></div>
    <section class="section section-intro" <?php echo $section_intro['background_image'] ? 'style="background-image: url(' . $section_intro['background_image'] . ');"' : ''; ?>>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <?php if ( $section_intro['title'] ) : ?>
	                    <div class="title">
	                        <h1><?php echo $section_intro['title']; ?></h1>
	                        <p><?php echo $section_intro['description']; ?></p>
	                    </div>
	                <?php endif; ?>
	                <?php
	                	$intro_button = $section_intro['button'];
	                	if ( $intro_button ) : 
	                		$intro_button_url = $intro_button['url'];
	                		$intro_button_title = $intro_button['title'];
	                ?>
	                    <div class="text-center text-lg-left">
	                        <a href="<?php echo $intro_button_url; ?>" class="btn btn-primary btn-lg">
	                        	<?php echo $intro_button_title; ?>
	                        </a>
	                    </div>
	                <?php endif; ?>
                </div>
                <div class="col-lg-6 mt-10 mt-lg-0">
                    <a href="https://www.youtube.com/channel/UC4N6F-esaSIo8fnHtF3fq3A" target="_blank" class="video">
                        <i class="icon icon-youtube"></i>
                        <?php if ( $section_intro['image'] ) : ?>
		                    <div class="text-center">
		                        <img src="<?php echo $section_intro['image']; ?>" class="section__image" alt="">
		                    </div>
		                <?php endif; ?>
                        <div class="video__caption">
                            <p>Frilanser bo'lib ishlash uchun nimalar kerak?</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Section - What Is Freelancing -->
    <?php
    	$section_what = get_field('what');
    ?>
    <div class="anchor" id="what"></div>
    <section class="section section-what pb-7">
        <div class="container">
        	<?php if ( $section_what['title'] ) : ?>
	            <div class="title title--center">
                    <h2><?php echo $section_what['title']; ?></h2>
                    <p><?php echo $section_what['description']; ?></p>
	            </div>
	        <?php endif; ?>
            <div class="freelancing">
            	<?php for ($i=1; $i < 5; $i++) : ?>
            		<?php if ( $section_what['steps']['title_' . $i] ) : ?>
	            		<div class="freelancing__item freelancing__item-<?php echo $i; ?>">

							<?php if ( $section_what['steps']['icon_' . $i] ) : ?>
							    <div class="freelancing__item-image">
							        <img src="<?php echo $section_what['steps']['icon_' . $i] ?>" alt="">
							    </div>
							<?php endif; ?>
	            			
		                    <div>
		                        <strong><?php echo $section_what['steps']['title_' . $i]; ?></strong>
		                        <p><?php echo $section_what['steps']['description_' . $i]; ?></p>
		                    </div>
		                </div>
		            <?php endif; ?>
            	<?php endfor; ?>
                <?php if ( $section_what['image'] ) : ?>
	                <div class="freelancing__center">
	                	<img src="<?php echo $section_what['image']; ?>">
	                </div>
                <?php endif; ?>
            </div>
            <?php
            	$what_button = $section_what['button'];
            	if ( $what_button ) : 
            		$what_button_url = $what_button['url'];
            		$what_button_title = $what_button['title'];
            ?>
                <div class="text-center mt-10">
                    <a href="<?php echo $what_button_url; ?>" class="btn btn-primary btn-lg">
                    	<?php echo $what_button_title; ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <div class="sections-gradient-1">
        <div class="position-relative">

            <!-- Section - Who Can Be Freelancer -->
            <?php
            	$section_who = get_field('who');
            ?>
            <div class="anchor" id="who"></div>
            <section class="section section-who pb-0">
                <div class="container">
                    <div class="row align-items-end">
                        <div class="col-lg-6 order-lg-2">
				        	<?php if ( $section_who['title'] ) : ?>
					            <div class="title">
				                    <h2><?php echo $section_who['title']; ?></h2>
				                    <p><?php echo $section_who['description']; ?></p>
					            </div>
					        <?php endif; ?>
                            <div class="checklist mb-4">
                                <ul>
                                	<?php for ($i=1; $i < 17; $i++) : ?>
	                                	<?php if ( $section_who['list_items']['item_' . $i] ) : ?>
		                                    <li><?php echo $section_who['list_items']['item_' . $i]; ?></li>
		                                <?php endif; ?>
		                            <?php endfor; ?>
                                </ul>
                            </div>
				            <?php
				            	$who_button = $section_who['button'];
				            	if ( $who_button ) : 
				            		$who_button_url = $who_button['url'];
				            		$who_button_title = $who_button['title'];
				            ?>
			                    <a href="<?php echo $who_button_url; ?>" class="btn btn-primary">
			                    	<?php echo $who_button_title; ?>
			                    </a>
			                <?php endif; ?>
                        </div>
                        <div class="col-lg-6  mt-10 mt-lg-0 order-lg-1">
			                <?php if ( $section_who['image'] ) : ?>
	                            <div class="text-center">
				                	<img src="<?php echo $section_who['image']; ?>" class="section__image">
				                </div>
			                <?php endif; ?>
                        </div>
                    </div>
                    <hr>
                </div>
            </section>

            <!-- Section - Platforms -->
            <?php
            	$section_platforms_title = get_field('section_platforms_title');
            	$platforms = get_field('platforms');
            ?>
            <div class="anchor" id="platforms"></div>
            <section class="section pb-9">
                <div class="container">
		        	<?php if ( $section_platforms_title ) : ?>
			            <div class="title title--center">
		                    <h2><?php echo $section_platforms_title; ?></h2>
			            </div>
			        <?php endif; ?>
                    <div class="platforms">
                        <div class="row row-min justify-content-center">
                        	<?php for ($i=1; $i < 6; $i++) : ?>
                        		<?php if ( $platforms['icon_' . $i] && $platforms['link_' . $i]['title'] ) : 
                        			$platform_link = $platforms['link_' . $i];
			                		$platform_link_url = $platform_link['url'];
			                		$platform_link_title = $platform_link['title'];
			                		$platform_link_target = $platform_link['target'] ? $platform_link['target'] : '_self';
                        		?>
		                            <div class="col col-platform">
		                                <div class="platform">
		                                    <a href="<?php echo $platform_link_url; ?>" class="platform__icon" target="<?php echo esc_attr( $platform_link_target ); ?>">
		                                        <img src="<?php echo $platforms['icon_' . $i]; ?>" alt="<?php echo $platform_link_title; ?>">
		                                        <div style="color: <?php echo $platforms['color_' . $i] ? $platforms['color_' . $i] : '#000'; ?>">
		                                            <span><?php echo $platform_link_title; ?></span>
		                                            <small style="background-color: <?php echo $platforms['color_' . $i] ? $platforms['color_' . $i] : '#000'; ?>"></small>
		                                        </div>
		                                    </a>
		                                    <div class="platform__caption">
		                                        <strong>Best for:</strong>
		                                        <ul>
		                                        	<?php for ($j=1; $j < 7; $j++) : if ( $platforms['best_for_items_' . $i]['item_' . $j] ) : ?>
			                                            <li><?php echo $platforms['best_for_items_' . $i]['item_' . $j]; ?></li>
			                                        <?php endif; endfor; ?>
		                                        </ul>
		                                    </div>
		                                </div>
		                            </div>
		                        <?php endif; ?>
	                        <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

    <!-- Section - How Do You Learn -->
    <?php
    	$section_how_title = get_field('section_how_title');
    	$section_how_description = get_field('section_how_description');
    	$section_how_items = get_field('how_items');
	?>
	<div class="anchor" id="how"></div>
    <section class="section section-how bg-white pb-0">
        <div class="container">
            <?php if ( $section_how_title ) : ?>
                <div class="title title--center">
                    <h2><?php echo $section_how_title; ?></h2>
                    <p><?php echo $section_how_description; ?></p>
                </div>
            <?php endif; ?>
            <div class="steps">
                <div class="row justify-content-center">
                	<?php for ($i=1; $i < 4; $i++) : ?>
                		<?php if ( $section_how_items['title_' . $i] && $section_how_items['image_' . $i] ) : ?>
		                    <div class="col-md-6 col-lg-4">
		                        <div class="step">
		                            <div class="step__number"><?php echo $i; ?></div>
		                            <img src="<?php echo $section_how_items['image_' . $i] ?>" alt="<?php echo $section_how_items['title_' . $i]; ?>">
		                            <?php if ( $section_how_items['title_' . $i] ) : ?>
				                        <strong><?php echo $section_how_items['title_' . $i]; ?></strong>
				                    <?php endif; ?>
			                        <?php if ( $section_how_items['description_' . $i] ) : ?>
				                        <p><?php echo $section_how_items['description_' . $i]; ?></p>
				                    <?php endif; ?>
		                        </div>
		                    </div>
		                <?php endif; ?>
	                <?php endfor; ?>
                </div>
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/waved-line.png'; ?>" class="step-waved-line" alt="Waved line">
            </div>
        </div>
    </section>

    <!-- Section - About Zafarbek Ibrohimov -->
    <?php
    	$section_about_title = get_field('section_about_title');
    	$section_about_description = get_field('section_about_description');
    	$section_about_blockquote = get_field('section_about_blockquote');
    	$section_about_image = get_field('section_about_image');
    ?>
    <div class="anchor" id="about"></div>
    <section class="section section-about bg-white pt-6">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-lg-6 section-about-col-1">
		            <?php if ( $section_about_title ) : ?>
		                <div class="title justify-content-start text-left mb-2">
		                    <h2><?php echo $section_about_title; ?></h2>
		                </div>
		            <?php endif; ?>
		            <?php if ( $section_about_title ) : ?>
	                    <div class="mb-6">
	                        <p><?php echo $section_about_description; ?></p>
	                    </div>
		            <?php endif; ?>
		            <?php if ( $section_about_blockquote['text'] ) : ?>
	                    <div class="blockquote pr-xl-12">
	                        <blockquote>
	                            <p><?php echo $section_about_blockquote['text']; ?></p>
	                        </blockquote>
	                        <span><?php echo $section_about_blockquote['author']; ?></span>
	                    </div>
		            <?php endif; ?>
                </div>
                <div class="col-lg-6 section-about-col-2">
		            <?php if ( $section_about_image ) : ?>
	                    <div class="text-center">
	                        <img src="<?php echo $section_about_image; ?>" class="section__image" alt="">
	                    </div>
		            <?php endif; ?>
                </div>
            </div>

            <?php
            	$profiles = get_field('about_profiles');
		    	$pages = get_field('about_pages');
            ?>
            <div class="row">
                <div class="col-lg-6">
                	<div class="follow-pages">
                		<strong>Check my freelance profiles:</strong>
                		<ul>
                			<?php for ($i=1; $i < 6; $i++) : ?>
                				<?php if ($profiles['icon_' . $i] && $profiles['link_' . $i]) : ?>
		            				<li>
		            					<a href="<?php echo $profiles['link_' . $i]; ?>" target="_blank">
			            					<img src="<?php echo $profiles['icon_' . $i]; ?>" alt="">
			            				</a>
			            			</li>
			            		<?php endif; ?>
	            			<?php endfor; ?>
                		</ul>
                	</div>
                </div>
                <div class="col-lg-6">
                	<div class="follow-pages">
                		<strong>Follow me on:</strong>
                		<ul>
                			<?php for ($i=1; $i < 6; $i++) : ?>
                				<?php if ($pages['icon_' . $i] && $pages['link_' . $i]) : ?>
		            				<li>
		            					<a href="<?php echo $pages['link_' . $i]; ?>" target="_blank">
			            					<img src="<?php echo $pages['icon_' . $i]; ?>" alt="">
			            				</a>
			            			</li>
			            		<?php endif; ?>
	            			<?php endfor; ?>
                		</ul>
                	</div>
                </div>
	        </div>

        </div>
    </section>

    <div class="sections-gradient-2">
        <div class="position-relative">

            <!-- Section - Courses -->
            <?php
            	$section_courses_title = get_field('section_courses_title');
            	$courses = get_field('courses');
            ?>
            <div class="anchor" id="courses"></div>
            <section class="section section-courses pb-0">
                <div class="container">
                	<?php if ( $section_courses_title ) : ?>
	                    <div class="title title--center">
	                        <h2><?php echo $section_courses_title; ?></h2>
	                    </div>
                	<?php endif; ?>
                    <div class="courses">
                        <div class="row row-min justify-content-center">
                        	<?php for ($i=1; $i < 6; $i++) : ?>
	                        	<?php // if ( $courses['title_' . $i] && $courses['icon_' . $i] ) : ?>
		                            <div class="col col-course">
		                                <div class="course">
		                                    <div class="course__icon">
		                                        <img src="<?php echo $courses['icon_' . $i] ?>" alt="<?php echo $courses['title_' . $i] ?>">
		                                    </div>
		                                    <strong><?php echo $courses['title_' . $i] ?></strong>
		                                    <?php if ( $courses['button_' . $i] ) : 
		                                    	$course_link_url = $courses['button_' . $i]['url'];
		                                    	$course_link_title = $courses['button_' . $i]['title'];
		                                    ?>
		                                    	<a href="<?php echo $course_link_url; ?>" class="btn btn-primary"><?php echo $course_link_title; ?></a>
			                                <?php else : ?>
			                                    <div class="btn-course-disabled">Coming Soon <span class="icon icon-arrow-right"></span></div>
			                                <?php endif; ?>
		                                </div>
		                            </div>
		                        <?php // endif; ?>
		                    <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section - Testimonials -->
            <?php
            	$section_testimonials_title = get_field('section_testimonials_title');
            	$section_testimonials_description = get_field('section_testimonials_description');
        	    $testimonials = new WP_Query( array(
			        'post_type'		 => 'home_testimonials',
			        'post_status'	 => 'publish',
			        'posts_per_page' => -1,
				) );
            ?>
            <div class="anchor" id="testimonials"></div>
            <section class="section section-testimonials pb-2">
                <div class="container">
		            <?php if ( $section_testimonials_title ) : ?>
		                <div class="title title--center">
		                    <h2><?php echo $section_testimonials_title; ?></h2>
		                    <p><?php echo $section_testimonials_description; ?></p>
		                </div>
		            <?php endif; ?>
                </div>
                <div class="testimonials">
                    <div id="testimonials_slider" class="owl-carousel">
                        <?php if ( $testimonials->have_posts() ) : ?>
						    <?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
					            <div class="item">
		                            <div class="testimonial">
		                                <div class="testimonial__left">
		                                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
		                                    <span>-<?php the_title(); ?></span>
		                                </div>
		                                <div class="testimonial__right">
		                                    <abbr>
		                                    	<?php
			                                    	$testimonials_content = get_the_content();
													$testimonials_content_stripped = strip_tags($testimonials_content, '<p>');
													echo '<p>' . $testimonials_content_stripped . '<span class="icon icon-quote"></span></p>';
		                                    	?>
		                                    </abbr>
		                                    <ul>
		                                    	<?php for ($i=1; $i < 4; $i++) : ?>
			                                    	<?php if ( get_field('client_from')['logo_' . $i] ) : ?>
				                                        <li><img src="<?php echo get_field('client_from')['logo_' . $i]; ?>" alt=""></li>
				                                    <?php endif; ?>
				                                <?php endfor; ?>
		                                    </ul>
		                                </div>
		                            </div>
		                        </div>
						    <?php endwhile; ?>
						    <?php wp_reset_postdata(); ?>
						<?php else : ?>
						    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
						<?php endif; ?>
                    </div>
                    <div id="testimonials_slider_nav" class="owl-nav"></div>
                    <div class="container">
                        <hr>
                    </div>
                </div>
            </section>

            <!-- Section - Videos -->
		    <?php
		    	$section_videos_title = get_field('section_videos_title');
		    	$section_videos_description = get_field('section_videos_description');
		    	$videos = get_field('videos');
		    ?>
		    <div class="anchor" id="video_courses"></div>
            <section class="section section-video-courses pb-11">
                <div class="container">
		            <?php if ( $section_videos_title ) : ?>
		                <div class="title title--center">
		                    <h2><?php echo $section_videos_title; ?></h2>
		                    <p><?php echo $section_videos_description; ?></p>
		                </div>
		            <?php endif; ?>
                    <div class="video-courses">
                        <div class="row">
                        	<?php if ( $videos['url_1'] ) : ?>
	                            <div class="col-12">
	                                <a href="javascript:;" class="video" data-toggle="modal" data-target="#youtubeVideo_1">
	                                    <i class="icon icon-youtube"></i>
	                                    <img src="<?php echo $videos['image_1']; ?>" alt="<?php echo $videos['title_1']; ?>">
	                                    <div class="video__caption">
	                                        <p><?php echo $videos['title_1']; ?></p>
	                                    </div>
	                                </a>
	                            </div>
	                        <?php endif; ?>
                        	<?php if ( $videos['url_2'] ) : ?>
	                            <div class="col-md-6">
	                                <a href="javascript:;" class="video video--min" data-toggle="modal" data-target="#youtubeVideo_2">
	                                    <i class="icon icon-youtube"></i>
	                                    <img src="<?php echo $videos['image_2']; ?>" alt="<?php echo $videos['title_2']; ?>">
	                                    <div class="video__caption">
	                                        <p><?php echo $videos['title_2']; ?></p>
	                                    </div>
	                                </a>
	                            </div>
	                        <?php endif; ?>
                        	<?php if ( $videos['url_3'] ) : ?>
	                            <div class="col-md-6">
	                                <a href="javascript:;" class="video video--min" data-toggle="modal" data-target="#youtubeVideo_3">
	                                    <i class="icon icon-youtube"></i>
	                                    <img src="<?php echo $videos['image_3']; ?>" alt="<?php echo $videos['title_3']; ?>">
	                                    <div class="video__caption">
	                                        <p><?php echo $videos['title_3']; ?></p>
	                                    </div>
	                                </a>
	                            </div>
	                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

    <!-- Section - Call To Action -->
    <?php
    	$section_cta_bg_image = get_field('background_image');
    	$section_cta_title = get_field('section_cta_title');
    	$section_cta_description = get_field('section_cta_description');
    	$section_cta_background_image = get_field('section_cta_background_image');
    ?>
    <div class="anchor" id="calltoaction"></div>
    <section class="section section-calltoaction" <?php echo $section_cta_bg_image ? 'style="background-image: url(' . $section_cta_bg_image . ');"' : ''; ?>>
        <div class="container">
            <?php if ( $section_cta_title ) : ?>
                <div class="title title--center">
                    <h2><?php echo $section_cta_title; ?></h2>
                    <p><?php echo $section_cta_description; ?></p>
                </div>
            <?php endif; ?>
            <?php if ( get_field('section_cta_button') ) : ?>
	            <div class="text-center">
	                <a href="<?php echo  get_field('section_cta_button')['url']; ?>" class="btn btn-primary">
	                	<?php echo  get_field('section_cta_button')['title']; ?>
	                </a>
	            </div>
	        <?php endif; ?>
        </div>
    </section>
</main>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3">
            	<?php if (get_field('logo')) : ?>
					<div class="footer__logo">
			            <img src="<?php the_field('logo'); ?>" alt="IT Stars">
					</div>
				<?php endif; ?>
            </div>
            <div class="col-lg-6">
            	<?php if ( get_field('copyright') ) : ?>
	                <div class="footer__copyright">
	                    <p><?php the_field('copyright') ?></p>
	                </div>
	            <?php endif; ?>
            </div>
            <div class="col-lg-3">
                <div class="footer__socials">
                    <ul>
                    	<?php for ($i=1; $i < 7; $i++) : ?>
		                	<?php $social_link = get_field('socials')['link_' . $i]; if ( $social_link ) : ?>
		                		<?php
			                		$social_link_url = $social_link['url'];
			                		$social_link_title = $social_link['title'];
			                		$social_link_target = $social_link['target'] ? $social_link['target'] : '_self';
		                		?>
		                        <li>
		                        	<a href="<?php echo $social_link_url; ?>" target="<?php echo esc_attr( $social_link_target ); ?>" class="<?php echo $social_link_title; ?>">
			                        	<span class="icon icon-<?php echo $social_link_title; ?>"></span>
			                        </a>
			                    </li>
		                    <?php endif; ?>
		                <?php endfor; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Video modals -->
<?php if ( $videos['url_1'] ) : ?>
	<div class="modal fade modal-style-1" id="youtubeVideo_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered modal-lg">
	        <div class="modal-content">
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                <span class="icon icon-remove"></span>
	            </button>
	            <div class="modal-body p-0 d-flex">
	                <iframe width="100%" height="450" src="<?php echo $videos['url_1']; ?>" frameborder="0" allowfullscreen></iframe>
	            </div>
	        </div>
	    </div>
	</div>
<?php endif; ?>
<?php if ( $videos['url_2'] ) : ?>
	<div class="modal fade modal-style-1" id="youtubeVideo_2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered modal-lg">
	        <div class="modal-content">
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                <span class="icon icon-remove"></span>
	            </button>
	            <div class="modal-body p-0 d-flex">
	                <iframe width="100%" height="450" src="<?php echo $videos['url_2']; ?>" frameborder="0" allowfullscreen></iframe>
	            </div>
	        </div>
	    </div>
	</div>
<?php endif; ?>
<?php if ( $videos['url_3'] ) : ?>
	<div class="modal fade modal-style-1" id="youtubeVideo_3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered modal-lg">
	        <div class="modal-content">
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                <span class="icon icon-remove"></span>
	            </button>
	            <div class="modal-body p-0 d-flex">
	                <iframe width="100%" height="450" src="<?php echo $videos['url_3']; ?>" frameborder="0" allowfullscreen></iframe>
	            </div>
	        </div>
	    </div>
	</div>
<?php endif; ?>

<script src="<?php echo get_stylesheet_directory_uri() . '/assets/js/jquery.min.js'; ?>"></script>
<script src="<?php echo get_stylesheet_directory_uri() . '/assets/js/bootstrap.bundle.min.js'; ?>"></script>
<script src="<?php echo get_stylesheet_directory_uri() . '/assets/js/owl.carousel.js'; ?>"></script>
<script src="<?php echo get_stylesheet_directory_uri() . '/assets/js/main.js'; ?>"></script>
</body>
</html>