<div class="comment-container">
  <div class="posted-by">
    <div class="pic">
      <?php if (empty($comment['profile_pic'])) : ?>
        <img src="assets/dummy.jpg" alt="">
      <?php else : ?>
        <img src="data:image;base64, <?php echo (base64_encode($comment['profile_pic'])); ?>" alt="">
      <?php endif; ?>
    </div>
    <h5 class="uname"><?php echo $comment['user_name'] ?></h5>
  </div>
  <div class="comment">
    <p><?php echo $comment['comment'] ?></p>
  </div>
</div>
