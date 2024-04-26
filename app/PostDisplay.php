<div class="post-container post-row">
  <div class="posted-by">
    <div class="pic">
      <?php if (empty($post['profile_pic'])): ?>
        <img src="assets/dummy.jpg" alt="">
      <?php else: ?>
        <img src="data:image;base64, <?php echo (base64_encode($post['profile_pic'])); ?>" alt="">
      <?php endif; ?>
    </div>
    <h5 class="uname"><?php echo $post['user_name'] ?></h5>
  </div>
  <div class="post">
    <p ><?php echo $post['content'] ?></p>
    <?php if ($post['media']): ?>
      <img src="data:<?php echo $post['media_type'];?>;base64, <?php echo (base64_encode($post['media'])); ?>" alt="">
    <?php endif; ?>
  </div>
  <div id="like-con" data-post-id="<?php echo $post['post_id'];?>">
    <div id="thumbs">
      <?php if (!in_array($post['post_id'],array_column($liked_posts,'post_id'))): ?>
        <i class="uil uil-thumbs-up"></i>
      <?php else:?>
        <i class="fa-solid fa-thumbs-up"></i>
      <?php endif;?>  
    </div>
    <div id="like-count">
        <?php echo $post['likes'];?>
    </div>
  </div>
  <div id="comment-btn" data-post-id="<?php echo $post['post_id'];?>">
    <i class="fa-regular fa-comment"></i>
    <div id="comm-count"> 
      <?php echo $read->getTotalComments($post['post_id']);?>
    </div>
  </div>
  <div id="comments-display">
    <div id="post-comment" data-post-id="<?php echo $post['post_id'];?>">
      <form id="commentForm">
        <label for="post_comm">Write a Comment</label>
        <textarea name="post_comm" id="post_comm" cols="30" rows="3"></textarea>
        <input type="submit" name="comment" value="Comment" id="comment-submit">
      </form>
    </div>
    <div id="comments"></div>
  </div>
</div>
