<?php
/*
 * Custom Feedback
 * ===============
 * https://codex.wordpress.org/Function_Reference/wp_list_comments#Comments_Only_With_A_Custom_Comment_Display
*/

function b5st_comment($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
  extract($args, EXTR_SKIP);
  if ( 'div' == $args['style'] ) {
      $tag = 'div';
      $add_below = 'comment';
  } else {
      $tag = 'li';
      $add_below = 'div-comment';
  }
?>

<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
<?php if ( 'div' != $args['style'] ) : ?>
  <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
<?php endif; ?>

  <div class="comment-author vcard d-flex">
    <div class="pe-3">

        <?php echo get_avatar( $comment->comment_author_email, $size = '52'); ?>
    </div>
    <div>
        <a href="<?php echo get_comment_author_url(); ?>" target="_blank"><h4 class="m-0 comment-author-name"><?php comment_author(); ?></h4></a>
      <p class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf('%1$s ' . __('', 'mini-bootstrap5') . ' %2$s', get_comment_date(), get_comment_time()) ?></a></p>
      <?php if ($comment->comment_approved == '0') : ?>
        <p><em class="comment-awaiting-moderation"><?php _e('你的评论正等待审核', 'mini-bootstrap5') ?></em></p>
      <?php endif; ?>
    </div>
  </div>

  <div>
    <?php comment_text() ?>
  </div>

  <div class="reply">
    <p>
      <?php comment_reply_link( array_merge( $args, array(
        'add_below' => $add_below,
        'reply_text' => __('<i class="bi bi-reply"></i> 回复', 'textdomain'),
        'depth' => $depth,
        'max_depth' => $args['max_depth']
        ))
      ); ?>
      <?php edit_comment_link('<span class="btn btn-secondary">' . __('<i class="bi bi-pen"></i> 编辑', 'mini-bootstrap5') . '</span>',' ','' ); ?>
    </p>
  </div>

<?php if ( 'div' != $args['style'] ) : ?>
</div>
<?php endif; }

/**!
 * Custom Comments Form
 */

// Do not delete this section
if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])){
  die ('Please do not load this page directly. Thanks!'); }
if ( post_password_required() ) { ?>
  <section id="post-comments">
    <div class="comments-wrap">
      <div class="alert alert-warning">
        <?php _e('文章被密码保护，输入密码查看评论', 'mini-bootstrap5'); ?>
      </div>
    </div>
  </section>
<?php
  return;
} // End do not delete section

if (have_comments()) : ?>

  <secion id="post-comments">
    <div class="comments-wrap container">
      <h3 class="pt-3 mt-5 mb-3">
        <?php printf(
          /* translators: 1: title. */
          esc_html__( '评论', 'mini-bootstrap5' ),
          '<span>' . get_the_title() . '</span>'
        );?>
      </h3>

      <p><i class="bi bi-chat-text"></i> <?php
          $comment_count = get_comments_number();
          if ( '1' === $comment_count ) {
            printf(
              /* translators: 1: title. */
              esc_html__( '有一条评论发布在 &ldquo;%1$s&rdquo;', 'mini-bootstrap5' ),
              '<span>' . get_the_title() . '</span>'
            );
          } else {
            printf(
              /* translators: 1: comment count number, 2: title. */
              esc_html( _nx( '有 %1$s 条评论在 &ldquo;%2$s&rdquo;', '有 %1$s 条评论在 &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'mini-bootstrap5' ) ),
              number_format_i18n( $comment_count ),
              '<span>' . get_the_title() . '</span>'
            );
          }
        ?>
      </p>

      <ol class="comment-list pb-3">
        <?php wp_list_comments('type=comment&callback=b5st_comment');?>
      </ol><!-- /.comment-list -->

      <p class="text-muted">
        <?php paginate_comments_links(); ?>
      </p>
    </div>
  </section>  
<?php
  else :
	  if (comments_open()) :
      echo '<section id="post-comments"><div class="comments-wrap container first-to-comment"><p class="alert alert-info mt-5">' . __('成为第一个发表评论的人吧！', 'mini-bootstrap5') . '</p></div></section>';
		else :
			echo '<section id="post-comments"><div class="comments-wrap container"><p class="alert alert-info">' . __('评论已经关闭...', 'mini-bootstrap5') . '</p></div></section>';
		endif;
	endif;
?>

<?php if (comments_open()) : ?>
<section id="respond" class="container py-3">
  <div class="comments-wrap bg-light border px-3 py-1">
    <div>
        <h3 class="mt-3"><?php comment_form_title(__('发表评论', 'mini-bootstrap5'), __('回复给 %s', 'mini-bootstrap5')); ?></h3>
        <p>必填项将用 <span class="fs-4">*</span> 标记</p>
        <p><?php cancel_comment_reply_link(); ?></p>
        <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
        <p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'mini-bootstrap5'), wp_login_url(get_permalink())); ?></p>
        <?php else : ?>

        <form action="<?php echo site_url('/wp-comments-post.php') ?>" method="post" id="commentform">

          <?php if (is_user_logged_in()) : ?>
          <p>
            <?php if ( ! empty( $user_identity ) ) {
	            printf(__('登录为', 'mini-bootstrap5') . ' <a href="%s/wp-admin/profile.php">%s</a>.', get_option('url'), $user_identity);
            } ?>
            <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php __('登出该账户', 'mini-bootstrap5'); ?>"><?php echo __('登出', 'mini-bootstrap5') . ' <i class="bi bi-arrow-right"></i>'; ?></a>
          </p>
          <?php else : ?>

          <div class="form-group">
            <label for="author" class="mb-2">
              <?php _e('你的名字', 'mini-bootstrap5'); if ($req) echo '*'; ?>
            </label>
            <input type="text" class="form-control" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" <?php if ($req) echo 'aria-required="true"'; ?>>
          </div>

          <div class="form-group">
            <label for="email" class="my-2">
              <?php _e('你的邮箱地址', 'mini-bootstrap5'); if ($req) echo '*'; echo '<span class="text-muted">' . __('（不会公开发布）', 'mini-bootstrap5') . '</span>'; ?>
            </label>
            <input type="email" class="form-control" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" <?php if ($req) echo 'aria-required="true"'; ?>>
          </div>

          <div class="form-group">
            <label for="url" class="my-2">
              <?php echo __('你的网站', 'mini-bootstrap5') . '<span class="text-muted">' . __('（非必须）', 'mini-bootstrap5') . '</span>'; ?>
            </label>
            <input type="url" class="form-control" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>">
          </div>

          <?php endif; ?>

          <div class="form-group">
            <label for="comment" class="my-2"><?php _e('你的评论:', 'mini-bootstrap5'); ?></label>
            <textarea name="comment" class="form-control mt-1 mb-3" id="comment" rows="8" aria-required="true"></textarea>
          </div>

          <p><input name="submit" class="btn btn-primary" type="submit" id="submit" value="<?php _e('确认发布', 'mini-bootstrap5'); ?>"></p>

          <?php comment_id_fields(); ?>
          <?php do_action('comment_form', $post->ID); ?>
        </form>
        <?php endif; ?>

    </div>
  </div>
</section>
<?php endif; ?>
