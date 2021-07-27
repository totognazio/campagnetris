    <?php
    $page_protect->access_page(); // only set this this method to protect your page
    $page_protect->get_user_info();    
    $hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;
    #$image = $page_protect->get_user_image(" class=\"img-circle profile_img\" ");
    $jobrole  = $page_protect->get_job_role();

    
  // print_r($_SERVER['REQUEST_URI']);

//if (stripos($_SERVER['REQUEST_URI'],'gestioneCampagne') !== false) { $gestioneCampagne = 'class="active"';} else{$gestioneCampagne='';$admin='';}
if (stripos($_SERVER['REQUEST_URI'],'gestioneCampagne2') !== false) { $gestioneCampagne2 = 'class="active"';} else{$gestioneCampagne2='';$adminmenu='';}
if (stripos($_SERVER['REQUEST_URI'],'pianificazione2') !== false) { $pianificazione2 = 'class="active"';} else{$pianificazione2='';$adminmenu='';}
//if (stripos($_SERVER['REQUEST_URI'],'pianificazione') !== false) { $pianificazione = 'class="active"';} else{$pianificazione='';$admin='';}
if (stripos($_SERVER['REQUEST_URI'],'kickOff') !== false) { $kickOffmenu = ' class="current-page"';$adminmenu=' class="active"';$ul_admin=' style="display: block;"';} else{$kickOffmenu='';$adminmenu='';$ul_admin='';}
if (stripos($_SERVER['REQUEST_URI'],'users') !== false) { $usersmenu = ' class="current-page"'; $adminmenu=' class="active"';$ul_admin=' style="display: block;"';} else{$usersmenu='';$adminmenu='';$ul_admin='';}
if (stripos($_SERVER['REQUEST_URI'],'job_roles') !== false) { $job_rolesmenu = ' class="current-page"';$adminmenu=' class="active"';$ul_admin=' style="display: block;"';} else{$job_rolesmenu='';$adminmenu='';$ul_admin='';}
if (stripos($_SERVER['REQUEST_URI'],'campaign_stacks') !== false) { $stacksmenu = ' class="current-page"';$adminmenu=' class="active"';$ul_admin=' style="display: block;"';} else{$stacksmenu='';$adminmenu='';$ul_admin='';}
if (stripos($_SERVER['REQUEST_URI'],'squads') !== false) { $squadsmenu = ' class="current-page"';$adminmenu=' class="active"';$ul_admin=' style="display: block;"';} else{$squadsmenu='';$adminmenu='';$ul_admin='';}
if (stripos($_SERVER['REQUEST_URI'],'channels') !== false) { $channelsmenu = ' class="current-page"';$adminmenu=' class="active"';$ul_admin=' style="display: block;"';} else{$channelsmenu='';$adminmenu='';$ul_admin='';}
if (stripos($_SERVER['REQUEST_URI'],'segments') !== false) { $segmentsmenu = ' class="current-page"';$adminmenu=' class="active"';$ul_admin=' style="display: block;"';} else{$segmentsmenu='';$adminmenu='';$ul_admin='';}
if (stripos($_SERVER['REQUEST_URI'],'senders') !== false) { $sendersmenu = ' class="current-page"';$adminmenu=' class="active"';$ul_admin=' style="display: block;"';} else{$sendersmenu='';$adminmenu='';$ul_admin='';}

if (stripos($_SERVER['REQUEST_URI'],'sprints') !== false) { $sprintsmenu = ' class="current-page"';$adminmenu=' class="active"';$ul_admin=' style="display: block;"';} else{$sprintsmenu='';$adminmenu='';$ul_admin='';}
if (stripos($_SERVER['REQUEST_URI'],'campaign_categories') !== false) { $categoriesmenu = ' class="current-page"';$adminmenu=' class="active"';$ul_admin=' style="display: block;"';} else{$categoriesmenu='';$adminmenu='';$ul_admin='';}
if (stripos($_SERVER['REQUEST_URI'],'campaign_modalities') !== false) { $modalitiesmenu = ' class="current-page"';$adminmenu=' class="active"';$ul_admin=' style="display: block;"';} else{$modalitiesmenu='';$adminmenu='';$ul_admin='';}
if (stripos($_SERVER['REQUEST_URI'],'campaign_types') !== false) { $typesmenu = ' class="current-page"';$adminmenu=' class="active"';$ul_admin=' style="display: block;"';} else{$typesmenu='';$adminmenu='';$ul_admin='';}
if (stripos($_SERVER['REQUEST_URI'],'campaign_states') !== false) { $statesmenu = ' class="current-page"';$adminmenu=' class="active"';$ul_admin=' style="display: block;"';} else{$statesmenu='';$adminmenu='';$ul_admin='';}
//if (stripos($_SERVER['REQUEST_URI'],'campaign_titolo_sottotitolo') !== false) { $tit_sottmenu = ' class="current-page"';$adminmenu=' class="active"';$ul_admin=' style="display: block;"';} else{$tit_sottmenu='';$adminmenu='';$ul_admin='';}
if (stripos($_SERVER['REQUEST_URI'],'campaign_cat_sott') !== false) { $cat_sottmenu = ' class="current-page"';$adminmenu=' class="active"';$ul_admin=' style="display: block;"';} else{$cat_sottmenu='';$adminmenu='';$ul_admin='';}



    
?>

            <!-- sidebar menu -->
            <!-- sidebar menu -->
    <br><br>
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">        
        <div class="menu_section">
    
    <ul class="nav side-menu">
        <li><a href="http://ptcvw290.ced.h3g.it/campagneold/index.php" target="_blank"><i class="fa fa-dropbox"></i> Archivio Campagne  </a></li>
        <!--<li><a href="http://device-tools.h3g.it/campagneold/index.php?page=gestioneCampagne" target="_blank"><i class="fa fa-dropbox"></i> Archivio Campagne  </a></li>-->
    </ul>
    <br><br>
            <ul class="nav side-menu">   
               
                  
              
                <li <?php echo $gestioneCampagne2;?>><a href="index.php?page=gestioneCampagne2"><i class="fa fa-pencil-square-o"></i> Gestione </a></li>                                                       
                <li <?php echo $pianificazione2;?>><a href="index.php?page=pianificazione2"><i class="fa fa-table"></i> Pianificazione </a></li>                                                 
            
             <!--<h3> Administrator </h3>-->            
               
                
                

                <?php if ($jobrole>6) { ?>
                 <li  <?php echo $adminmenu;?>><a><i class="fa fa-gears"></i> Amministrazione <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" <?php echo $ul_admin; ?> >
                <li <?php echo $kickOffmenu;?> ><a href="index.php?page=gestioneStato">Gestione Stato Campagne</a></li>        
                        <?php if ($jobrole>7) { ?>   
                                                        
                            <li <?php echo $usersmenu;?>><a href="index.php?page=gestioneUtenti&table=users"> Users</a></li>
                            <li <?php echo $job_rolesmenu;?>><a href="index.php?page=gestioneAdmin&amp;table=job_roles"> Job Roles</a></li>
                            <li <?php echo $stacksmenu;?>><a href="index.php?page=gestioneAdmin&amp;table=campaign_stacks"> Stacks</a></li>
                            
                            <li  <?php echo $squadsmenu;?> ><a href="index.php?page=gestioneAdmin&amp;table=squads"> Squads</a></li>
                            <li <?php echo $channelsmenu;?>><a href="index.php?page=gestioneAdmin&amp;table=channels"> Channels</a></li>
                                 
                            <li <?php echo $segmentsmenu;?>><a href="index.php?page=gestioneAdmin&amp;table=segments"> Segments</a></li>
                            <li <?php echo $sendersmenu;?>><a href="index.php?page=gestioneAdmin&amp;table=senders"> Senders</a></li>
                            <li <?php echo $sprintsmenu;?>><a href="index.php?page=gestioneAdmin&amp;table=sprints"> Sprints</a></li>
                            <li <?php echo $categoriesmenu;?>><a href="index.php?page=gestioneAdmin&amp;table=campaign_categories"> Campaign Categories</a></li> 
                            <li <?php echo $modalitiesmenu;?>><a href="index.php?page=gestioneAdmin&amp;table=campaign_modalities"> Campaign Modalities</a></li>
                            <li <?php echo $typesmenu;?>><a href="index.php?page=gestioneAdmin&amp;table=campaign_types"> Campaign Typlogies</a></li> 
                            <li <?php echo $statesmenu;?>><a href="index.php?page=gestioneAdmin&amp;table=campaign_states"> Campaign States</a></li> 
                            <!--<li <?php #echo $tit_sottmenu;?>><a href="index.php?page=gestioneAdmin&amp;table=campaign_titolo_sottotitolo"> Titolo & Sottotitolo</a></li>  -->
                            <li <?php echo $cat_sottmenu;?>><a href="index.php?page=gestioneAdmin&amp;table=campaign_cat_sott"> Categoria & Sottocategoria</a></li>  
                            
                            
                             
                        <?php } ?>    
                        </ul>
                    </li>
                <?php } ?>
        
                    

            </ul>

        </div>

    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <!--<div class="sidebar-footer hidden-small">
        <a data-toggle="tooltip" data-placement="top" title="Settings">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Lock">
            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Logout">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
    </div>-->
    <!-- /menu footer buttons -->
</div>
</div>
