

<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOME_ADMIN') ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="categories.php"><?PHP echo lang('CATAGOREIS') ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><?PHP echo lang('sittings') ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="members.php?do=Edit&userId=<?php echo $_SESSION['ID'] ?>"><?PHP echo lang('profile') ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="items.php"><?PHP echo lang('ITEMS') ?></a>
      </li> 
      <li class="nav-item">
        <a class="nav-link" href="comments.php">COMMENTS</a>
      </li>  
      <li class="nav-item">
        <a class="nav-link" href="members.php"><?PHP echo lang('members') ?></a>
      </li>  
      
      <li class="nav-item">
        <a class="nav-link" href="../index.php"><?PHP echo lang('visit-show') ?></a>
      </li>      
      <li class="nav-item">
        <a class="nav-link" href="logout.php"><?PHP echo lang('log_out') ?></a>
      </li>    
    </ul>
  </div>  
</nav>
<br>
