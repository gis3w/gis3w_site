<?php
/**
* The page template file.
*
*/
   get_header(); 

?>
<div id="main-content">
<div class="breadcrumb-box">

            <?php singlepage_breadcrumb_trail(array("before"=>"","show_browse"=>false));?>
    
        </div>
 <?php 
							
							if ( have_posts() ) :
							 while ( have_posts() ) : the_post(); 
							?>
            	<div class="blog-main text-center" role="main">
                            <article class="post-entry text-left">
                                <div class="entry-main">
                                    <div class="entry-header">
                                    <h1 class="entry-title"><?php the_title();?></h1>
                                    </div>
                                    <div class="entry-content">
                                       <?php the_content();?>	
                                       <?php  wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'singlepage' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );?>
                                    </div>
                                </div>
                            </article>
                            <div class="comments-area text-left">
                             <?php
									echo '<div class="comment-wrapper">';
									comments_template(); 
									echo '</div>';
                                  ?>    
                            </div>
                        </div>
               <?php endwhile; endif;?>
                <div class="pagination"><?php singlepage_native_pagenavi("echo",$wp_query);?></div>
                 <div class="clear"></div>
            </div><!--END main-content-->
        </div><!--END main-->
      
        
        <div id="side">
    	 	<?php get_sidebar("page");?>
		</div>
        <div class="clear"></div>
        <div class="push"></div>
        
        </div><!--End wrapper-->
</div>
<?php get_footer(); ?>