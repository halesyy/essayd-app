<div class="profile-preview">
  <div class="picture" style="background-image: url('<?=(!empty($users_meta->picture))?$users_meta->picture:'public/images/none.png';?>')"></div>

  <div class="right">
    <i title="Logout" class="fa logout fa-sign-out" onclick="window.logout();" aria-hidden="true"></i>
  </div>

  <div class="middle">
    <button type="button" class="nice-button red" id="essay_latch">SAVE</button>
    <button type="button" class="nice-button" onclick="window.location.href = '/my-profile';">MY PROFILE</button>
    <button type="button" class="nice-button" onclick="window.location.href = '/dashboard';">DASHBOARD</button>
  </div>

  <div style="clear: both;"></div>
</div>

<script>
  if (window.location.hash.substring(1)) {
    $('#essay_latch').off().remove();
  }
  else {
    $(document).on('click', '#essay_latch', function(){
      window.modal('SaveEssay');
    });
  }
</script>
