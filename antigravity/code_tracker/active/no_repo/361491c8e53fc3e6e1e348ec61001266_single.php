Õ4<?php get_header(); ?>



    <div class="w-section2 novedades gcontainer no-pad">

        <div class="encabezado-seccion" style='background: url("<?php echo get_field('imagen_de_encabezado', 24); ?>") no-repeat;'>



            <h1 class="hseccion">Novedades</h1>

            <a href="#!" class="carrow-down"><img src="<?php echo get_template_directory_uri(); ?>/images/arrow-down.svg" width="38" height="28" alt=""></a>



        </div>

    </div><!-- end of .w-section2 -->





    <div class="w-section3 single gcontainer">



       <div class="container-fluid">



           <div id="single-novedad" class="flex-row">



               <div class="sidebar sleft">



                   <div class="buscador">

					   <form class="form-inline" method="get" action="<?php echo home_url(); ?>" role="search">

                          <div class="form-group">

                            <label class="sr-only" for="search">Buscar</label>

                            <input class="form-control" type="search" name="s" id="search" placeholder="Buscar..." >

                          </div>

                          <div class="form-group">

							  <button class="" type="submit" role="button"><span class="glyphicon glyphicon-search"></span></button>

                          </div>

                        </form>

                   </div>



                   <h3 class="hbold">Populares</h3>



                   <ul class="popus">

				        <?php

							$popular_posts_args = array(

							 'post_type' => 'novedades',

							 'posts_per_page' => 5,

							 'meta_key' => 'my_post_viewed',

							 'orderby' => 'meta_value_num',

							 'order'=> 'DESC'

							);

							 

							$popular_posts_loop = new WP_Query( $popular_posts_args );

							 

							while( $popular_posts_loop->have_posts() ):

							 $popular_posts_loop->the_post(); ?>

							    <li>

								   <h4><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4>

								   <p class="fecha"><?php echo la_fecha(get_the_time("w-j-n-Y")); ?></p>

							    </li>

                        <?php

						    endwhile;

						    wp_reset_query();

						?>

                   </ul>



                   <div class="compartir flex-row">

                       <p>compartir</p>

                       <a href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]=<?php echo urlencode(get_permalink()); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/face-gray-icon.svg" alt="" class="svg" /></a>

                       <a href="<?php echo get_field('instagram', 26);?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/insta-gray-icon.svg" alt="" class="svg" /></a>

                   </div>

               </div>



               <div class="single-contenido">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					   <article class="post">

							<h2 class="single-title"><?php echo get_the_title(); ?></h2>



							<?php if ( has_post_thumbnail()) : ?>

								<figure class="feat-image">

									<?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>

								</figure>

							<?php endif; ?>

								

							<div class="entry">

								<?php echo the_content(); ?>

							</div>





							<?php

							$images = get_field('galeria_noved');

										

							if( $images ):

							?>



							<div id='carousel-custom' class="carousel slide car-noves" data-ride="carousel" data-interval="5000">



							<div class='carousel-outer'>

								<!-- Wrapper for slides -->

								<div class='carousel-inner'>

									<?php

										//$images = get_field('galeria_noved');

										

										//if( $images ):



											for ($i=0; $i < count($images); $i++): ?>



											<div class="item <?php if($i == 0) echo 'active'; ?>">

												<?php $imgid2 = $images [$i]['ID']; ?>

												<?php echo wp_get_attachment_image( $imgid2, "full" ); ?>

											</div>							   



									<?php

											endfor;



										//endif;

									?>

								</div>



								<!-- Controls -->

									<a class='left carousel-control' href='#carousel-custom' data-slide='prev'>

										<span class='glyphicon glyphicon-chevron-left'></span>

									</a>

									<a class='right carousel-control' href='#carousel-custom' data-slide='next'>

										<span class='glyphicon glyphicon-chevron-right'></span>

									</a>

								</div>



								<!-- Indicators -->

								<ol class='carousel-indicators mCustomScrollbar'>

									<?php

										if( $images ):



											for ($x=0; $x < count($images); $x++): ?>

											

												<li data-target='#carousel-custom' data-slide-to='<?php echo $x; ?>' class='<?php if($x == 0) echo 'active'; ?>'>

													<?php $imgid = $images [$x]['ID']; ?>

													<?php echo wp_get_attachment_image( $imgid, "thumbnail-carrusel-capacitacion" ); ?>

												</li>

									<?php

											endfor;



										endif;

									?>

								</ol>



								<div id="menu-car-inf">

									<a class="left carousel-control" href="#carousel-custom" role="button" data-slide="prev"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><span class="sr-only">Previous</span></a>

									<a class="right carousel-control" href="#carousel-custom" role="button" data-slide="next"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span><span class="sr-only">Next</span></a>

								</div>



							</div> <!-- end of .carousel -->

							<?php endif; ?>



					   </article>

					   <hr class="hr" style="clear:both;">

					   <div class="compartir flex-row">

						   <p>compartir</p>

						   <a href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]=<?php echo urlencode(get_permalink()); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/face-gray-icon.svg" alt="" class="svg" /></a>

						   <a href="<?php echo get_field('instagram', 26);?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/insta-gray-icon.svg" alt="" class="svg" /></a>

					   </div>

					<?php endwhile; endif; ?>

               </div>



           </div> <!-- end of .w-section4 -->



       </div>



    </div><!-- end of .w-section3 -->

   



<?php get_footer(); ?>Õ42Jfile:///c:/xampp/htdocs/elgalpon/wp-content/themes/galpon-theme/single.php