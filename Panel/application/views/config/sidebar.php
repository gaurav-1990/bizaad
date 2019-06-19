
<body class="sidebar-expanded">


    <!-- Preloader -->
    <div class="preloader loader"></div>

    <header class="header">

        <div class="top-line">

            <a href="#" class="brand">

                <div class="brand-big">
<!--                    <span class="strong"><img src="<?= base_url('bootstrap/images/shp.png') ?>" style="width: 70%" alt="" /></span>-->
                    <span class="strong">Bizaad</span>
                </div>

                <div class="brand-small">
                    Biz
                </div>
            </a>

            <div class="menu-button">
                <a href="#" class="sidebar-toggle menu-toggle open">
                    <div class="menu-icon">
                        <span></span><span></span><span></span>
                        <span></span><span></span><span></span>
                    </div>
                </a>
            </div>

            <div class="navigation-top">


                <ul class="navbar-top navbar-top-right">


                    <li class="dropdown">
                        <?php $userProfile = getUserProfile($this->session->userdata('signupSession')['id']); ?>
                        <!-- Profile avatar -->
                        <a href="#" class="dropdown-toggle nav-profile" data-toggle="dropdown">
                            <span class="profile-name"><?= $userProfile->fname ?> <?= $userProfile->lname ?> </span>
                            <span class="caret"></span>
                            <div class="profile-avatar">
                                <div class="profile-avatar-image">
                                    <img src="<?= base_url() ?>allmedia/images/avatar-f-05.png" alt="">
                                </div>
                            </div>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="<?= site_url('SadminLogin/editProfile'); ?>"><i class="icon icon-inline fa fa-address-card-o"></i> Profile</a></li>

                            <li><a href="<?= site_url('SadminLogin/logout'); ?>"><i class="icon icon-inline fa fa-sign-out"></i> Sign out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sidebar custom-scrollbar">
            <div class="sidebar-content">
                <ul class="sidebar-navigation sb-nav">
                    <li class="sb-dropdown">
                        <a  href="#" class="sb-nav-item sb-nav-item <?= $active == 'dashboard' ? "active" : "" ?>">
                            <i class="icon fa fa-home"></i>
                            <span>Dashboard</span>
                        </a>

                    </li>
                    <?php if ($this->session->userdata('signupSession')['role'] == 1) { ?>
                        <li class="sb-dropdown">
                            <a href="#" class="sb-nav-item sb-dropdown-toggle <?= $active == 'profiles' ? "active" : "" ?>">
                                <i class="icon fa fa-leaf"></i>
                                <span>Vendor Sign-up</span>

                            </a>
                            <ul class="collapse">
                                <li>
                                    <a href="<?= site_url('SadminLogin/profiles'); ?>"  class="sb-nav-item  <?= $action == 'profilesview' ? "active" : "" ?>">
                                        <i class="icon fa fa-circle-o"></i> <span>View</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= site_url('SadminLogin/addAgents'); ?>" class="sb-nav-item">
                                        <i class="icon fa fa-circle-o"></i> <span>Add Vendor</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="<?= site_url('SadminLogin/categories'); ?>" class="sb-nav-item <?= $active == 'categories' ? "active" : "" ?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>View Categories</span>
                            </a>

                        </li>
                        <li>
                            <a href="<?= site_url('SadminLogin/addsub'); ?>" class="sb-nav-item <?= $active == 'addsubcategories' ? "active" : "" ?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>Add Sub Categories</span>
                            </a>

                        </li>
                        <li>
                            <a href="<?= site_url('SadminLogin/propName'); ?>" class="sb-nav-item <?= $active == 'propname' ? "active" : "" ?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>Properties Name</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('SadminLogin/addSubProp'); ?>" class="sb-nav-item <?= $active == 'attrname' ? "active" : "" ?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>Attribute Name</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('SadminLogin/addProp'); ?>" class="sb-nav-item <?= $active == 'addproperties' ? "active" : "" ?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>Properties</span>
                            </a>

                        </li>

                        <div class="sidebar-title">Vendor Requests</div>
                                                <li>
                                                    <a href="<?= base_url() ?>SadminLogin/requested_product" class="sb-nav-item <?= $active == 'request_pro' ? "active" : "" ?>">
                                                        <i class="icon fa fa-table"></i>
                                                        <span>View Products Request</span>
                                                    </a>
                                                </li>
                        <li>
                            <a href="<?= base_url('Vendor/onlineQuery') ?>" class="sb-nav-item  <?= $active == 'onlinequery' ? "active" : "" ?>">
                                <i class="icon fa fa-table"></i>
                                <span>Online Query</span>
                            </a>
                        </li>
                    <?php } ?>
			    <div class="sidebar-title">Vendor area</div>
                    <?php
                    $da = getUserProfile($this->session->userdata('signupSession')['id']);
                    if (($this->session->userdata('signupSession')['role'] == 1)) {
                        ?>   
                    

                        <li class="sb-dropdown">
                            <a href="#" class="sb-nav-item sb-dropdown-toggle <?= $active == 'addproducts' ? "active" : "" ?>">
                                <i class="icon fa fa-leaf"></i>
                                <span> Products</span>

                            </a>

                            <ul class="collapse">
                                <li>
                                    <a href="<?= site_url('Vendor/vendor_products') ?>"  class="sb-nav-item  <?= $action == 'profilesview' ? "active" : "" ?>">
                                        <i class="icon fa fa-circle-o"></i> <span>View Products</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= site_url('Vendor/addProducts'); ?>" class="sb-nav-item <?= $action == 'addproducts' ? "active" : "" ?>">
                                        <i class="icon fa fa-circle-o"></i> <span>Add Products</span>
                                    </a>
                                </li>
                            </ul>
			      <ul class="collapse">
                                <li>
                                    <a href="<?= site_url('Vendor/zeya_vendor_products_view') ?>"  class="sb-nav-item  <?= $action == 'profilesview' ? "active" : "" ?>">
                                        <i class="icon fa fa-circle-o"></i> <span>View Vendor Products</span>
                                    </a>
                                </li>
                                
                            </ul>
                        </li>

                         <li class="sb-dropdown">
                            <a href="#" class="sb-nav-item sb-dropdown-toggle <?= $active == 'addproducts' ? "active" : "" ?>">
                                <i class="icon fa fa-leaf"></i>
                                <span> Reports</span>

                            </a>

                            <ul class="collapse">
                                <li>
                                    <a href="<?= site_url('Vendor/report_datewise') ?>"  class="sb-nav-item  <?= $action == 'profilesview' ? "active" : "" ?>">
                                        <i class="icon fa fa-circle-o"></i> <span>Date wise</span>
                                    </a>
                                </li>
                               
                            </ul>
                        </li>

                        
                  
                        <li>
                            <a href="<?= base_url('Vendor/userOrder') ?>" class="sb-nav-item  <?= $active == 'orders' ? "active" : "" ?>">
                                <i class="icon fa fa-table"></i>
                                <span>Products order</span>
                            </a>
                        </li>
                        
                    <?php }elseif($this->session->userdata('signupSession')['role'] == 0||($da->allow_product == 1 && $this->session->userdata('signupSession')['role'] == 0)){ ?>
			
			 

                        <li class="sb-dropdown">
                            <a href="#" class="sb-nav-item sb-dropdown-toggle <?= $active == 'addproducts' ? "active" : "" ?>">
                                <i class="icon fa fa-leaf"></i>
                                <span> Products</span>

                            </a>

                            <ul class="collapse">
                                <li>
                                    <a href="<?= site_url('Vendor/zeya_vendor_products_view') ?>"  class="sb-nav-item  <?= $action == 'profilesview' ? "active" : "" ?>">
                                        <i class="icon fa fa-circle-o"></i> <span>View Vendor Products</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= site_url('Vendor/zeya_vendor_addProducts'); ?>" class="sb-nav-item <?= $action == 'addproducts' ? "active" : "" ?>">
                                        <i class="icon fa fa-circle-o"></i> <span>Add Vendor Products</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        
                  
                        <li>
                            <a href="<?= base_url('Vendor/userOrder') ?>" class="sb-nav-item  <?= $active == 'orders' ? "active" : "" ?>">
                                <i class="icon fa fa-table"></i>
                                <span>Vendor Products order</span>
                            </a>
                        </li>

                       
			<?php 
		    
		    
		    
		    
		    }?>
                </ul>



            </div>
        </div>
        <!-- /Sidebar -->


    </header>