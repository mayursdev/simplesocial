<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reminder</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <span> You have been online for more then <?php echo ltrim(reminderInterval($so['user']['timer']),'+'); ?>..</span><br>Spending too much time infront of digital screens has harmful effects on health
      </div>
      <div class="modal-footer">
        <button type="button" onclick='location.href="<?php echo $so["site_url"];?>"' class="btn button-primary">OK</button>
      </div>
    </div>
  </div>
</div>

<style>
  .modal-footer .btn{
    font-size:1.4rem;
    font-weight:500
  }
  .modal-header{
    padding:1rem 2rem

  }
  .modal-title{
    font-size:1.8rem;
  }
  .modal-body{
    font-size:1.6rem;
    padding:2rem 2rem
  }
  .modal-body span{
    font-weight:500;
  }

</style>