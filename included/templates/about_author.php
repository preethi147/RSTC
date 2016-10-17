<div class="post-author">
    <h5><?php echo esc_html__('About Author', 'ri-quartz'); ?></h5>
    <div class="row">
        <div class="author-img col-sm-3 col-md-3">
          <?php if(get_the_author_meta('twitter')) : ?>
            <a href="<?php echo esc_url(the_author_meta('twitter')); ?>">

            <?php endif; ?>
            <?php echo wp_kses(get_avatar( get_the_author_meta('email'), '116' ),array('img'=>array('class'=>array(),'width'=>array(),'height'=>array(),'alt'=>array(),'src'=>array()))); ?>
            <?php if(get_the_author_meta('twitter')) : ?>
              </a>

              <?php endif; ?>
        </div>
        <div class="author-content col-sm-9 col-md-9 pl0">
            <h6><span><?php the_author_posts_link(); ?></span></h6>
            <p><?php the_author_meta('description'); ?></p>
            <ul class="author-social">
                <?php if(get_the_author_meta('facebook')) : ?><li><a target="_blank" class="author-social" href="http://facebook.com/<?php echo esc_url(the_author_meta('facebook')); ?>"><i class="fa fa-facebook"></i></a></li><?php endif; ?>
                <?php if(get_the_author_meta('twitter')) : ?><li><a target="_blank" class="author-social" href="http://twitter.com/<?php echo esc_url(the_author_meta('twitter')); ?>"><i class="fa fa-globe"></i></a></li><?php endif; ?>
                <?php if(get_the_author_meta('instagram')) : ?><li><a target="_blank" class="author-social" href="http://instagram.com/<?php echo esc_url(the_author_meta('instagram')); ?>"><i class="fa fa-instagram"></i></a></li><?php endif; ?>
                <?php if(get_the_author_meta('google')) : ?><li><a target="_blank" class="author-social" href="http://plus.google.com/<?php echo esc_url(the_author_meta('google')); ?>?rel=author"><i class="fa fa-google-plus"></i></a></li><?php endif; ?>
                <?php if(get_the_author_meta('pinterest')) : ?><li><a target="_blank" class="author-social" href="http://pinterest.com/<?php echo esc_url(the_author_meta('pinterest')); ?>"><i class="fa fa-pinterest"></i></a></li><?php endif; ?>
                <?php if(get_the_author_meta('tumblr')) : ?><li><a target="_blank" class="author-social" href="http://<?php echo esc_url(the_author_meta('tumblr')); ?>.tumblr.com/"><i class="fa fa-tumblr"></i></a></li><?php endif; ?>
            </ul>
        </div>
    </div>
</div>