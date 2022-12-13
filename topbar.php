

<div id="page" class="bg-dark">
</div>
<container>
</container>




<div id="loading"></div>
<nav class="bg-red">
  <div class="container-fluid mt-2 mb-2">
    <div class="col-lg-12">
      <div class="float-right">
        <div class=" dropdown mr-4">
          <a class="dropdown-item " href="ajax.php?action=logout"><p style="color:#FF0000";>Cerrar Sesion</p></a>
        </div>
      </div>
    </div>
  </div>

</nav>


<script>
  $('#manage_my_account').click(function() {
    uni_modal("Manage Account", "manage_user.php?id=<?php echo $_SESSION['login_id'] ?>&mtype=own")
  })
</script>