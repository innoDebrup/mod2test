$(document).ready(function() {
  $('.edit').preventDefault;
  $('form').hide();
  $('.edit').click(function() {
    let parent = $(this).parent();
    parent.find('form').toggle(200);
  });
});
