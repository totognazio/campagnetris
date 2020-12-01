        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                              <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <?php
                                    $page_protect->access_page(); // only set this this method to protect your page
                                    $page_protect->get_user_info();
                                    $hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;
                                   #echo $page_protect->get_user_image();
                                    echo $hello_name;
                                    ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href="./index.php?page=update_user_profile"> Profile</a></li>
                                    <!--<li>
                                        <a href="javascript:;">
                                            <span class="badge bg-red pull-right">50%</span>
                                            <span>Settings</span>
                                        </a>
                                    </li>
                                    <li><a href="javascript:;">Help</a></li>-->
                                    <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=log_out"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                </ul>
                            </li>
                  
                  
                  


                
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->