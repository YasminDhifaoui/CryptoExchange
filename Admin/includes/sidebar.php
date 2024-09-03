<aside class="sidebar sidebar-default navs-rounded ">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <a href="../dashboard/index.html" class="navbar-brand dis-none align-items-center justify-content-center">
                <img src="<?php echo htmlspecialchars($setting['logo']); ?>" width="50px" height="50px" style="border-radius:40px;">         
                <h4 class="logo-title m-0">CryptoLyrics</h4>
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5"></path>
                        <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5"></path>
                    </svg>
                </i>
            </div>
        </div>
        <div class="sidebar-body p-0 data-scrollbar">
            <div class="collapse navbar-collapse pe-3" id="sidebar">
                <ul class="navbar-nav iq-main-menu">
                    <li class="nav-item ">
                        <a class="nav-link active" aria-current="page" href="../dashboard/admin_dashboard.php">
                            <i class="icon">
                            <svg width="22" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.15722 20.7714V17.7047C9.1572 16.9246 9.79312 16.2908 10.581 16.2856H13.4671C14.2587 16.2856 14.9005 16.9209 14.9005 17.7047V17.7047V20.7809C14.9003 21.4432 15.4343 21.9845 16.103 22H18.0271C19.9451 22 21.5 20.4607 21.5 18.5618V18.5618V9.83784C21.4898 9.09083 21.1355 8.38935 20.538 7.93303L13.9577 2.6853C12.8049 1.77157 11.1662 1.77157 10.0134 2.6853L3.46203 7.94256C2.86226 8.39702 2.50739 9.09967 2.5 9.84736V18.5618C2.5 20.4607 4.05488 22 5.97291 22H7.89696C8.58235 22 9.13797 21.4499 9.13797 20.7714V20.7714" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>                            
                            </i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>

                    <!-- Users -->
                     <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-user" role="button" aria-expanded="false" aria-controls="sidebar-user">
                            <i class="icon">
                            <svg width="22" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.9849 15.3462C8.11731 15.3462 4.81445 15.931 4.81445 18.2729C4.81445 20.6148 8.09636 21.2205 11.9849 21.2205C15.8525 21.2205 19.1545 20.6348 19.1545 18.2938C19.1545 15.9529 15.8735 15.3462 11.9849 15.3462Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M11.9849 12.0059C14.523 12.0059 16.5801 9.94779 16.5801 7.40969C16.5801 4.8716 14.523 2.81445 11.9849 2.81445C9.44679 2.81445 7.3887 4.8716 7.3887 7.40969C7.38013 9.93922 9.42394 11.9973 11.9525 12.0059H11.9849Z" stroke="currentColor" stroke-width="1.42857" stroke-linecap="round" stroke-linejoin="round"></path> </svg>                            
                            </i>
                            <span class="item-name">Users</span>
                            <i class="right-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="sidebar-user" data-bs-parent="#sidebar">
                            <li class="nav-item">
                                <a class="nav-link " href="../users_management/users_list.php">
                                    <i class="icon">
                                    <svg width="10" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="1" width="11" height="11" stroke="currentcolor"/>
                                    </svg>                           
                                    </i>
                                    <i class="sidenav-mini-icon"> U </i>
                                    <span class="item-name">Users List</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="../users_management/create_user.php">
                                    <i class="icon">
                                        <svg width="10" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="1" width="11" height="11" stroke="currentcolor"/>
                                        </svg> 
                                    </i>
                                    <i class="sidenav-mini-icon"> U </i>
                                    <span class="item-name">Add User</span>
                                </a>
                            </li>
                            

                            <li class="nav-item">
                                <a class="nav-link " href="../users_management/verification_requests.php">
                                    <i class="icon">
                                        <svg width="10" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="1" width="11" height="11" stroke="currentcolor"/>
                                        </svg> 
                                    </i>
                                    <i class="sidenav-mini-icon"> U </i>
                                    <span class="item-name">Users verification</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="../users_management/blocklist.php">
                                    <i class="icon">
                                        <svg width="10" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="1" width="11" height="11" stroke="currentcolor"/>
                                        </svg> 
                                    </i>
                                    <i class="sidenav-mini-icon"> U </i>
                                    <span class="item-name">Blocklist</span>
                                </a>
                            </li>

                        </ul>
                    </li>

<!-- Admins -->
<li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-admin" role="button" aria-expanded="false" aria-controls="sidebar-admin">
        <i class="icon">
        <svg width="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C10.3431 2 9 3.34315 9 5C9 6.65685 10.3431 8 12 8C13.6569 8 15 6.65685 15 5C15 3.34315 13.6569 2 12 2ZM5 21C5 18.7909 8.68629 17 12 17C15.3137 17 19 18.7909 19 21H5Z" fill="currentColor"/>
            </svg>                          
        </i>
        <span class="item-name">Admins</span>
        <i class="right-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </i>
    </a>
    <ul class="sub-nav collapse" id="sidebar-admin" data-bs-parent="#sidebar">
        <li class="nav-item">
            <a class="nav-link" href="../admin_management/admin_list.php">
                <i class="icon">
                    <svg width="10" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="1" width="11" height="11" stroke="currentColor"/>
                    </svg>                           
                </i>
                <i class="sidenav-mini-icon"> A </i>
                <span class="item-name">Admin List</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../admin_management/create_admin.php">
                <i class="icon">
                    <svg width="10" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="1" width="11" height="11" stroke="currentColor"/>
                    </svg> 
                </i>
                <i class="sidenav-mini-icon"> A </i>
                <span class="item-name">Add Admin</span>
            </a>
        </li>
    </ul>
</li>

<!-- Currency -->

<li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-exchange" role="button" aria-expanded="false" aria-controls="sidebar-exchange">
        <i class="icon">
        <svg width="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5V3L8 7L12 11V9C15.87 9 19 12.13 19 16C19 16.35 18.97 16.7 18.91 17.04L20.3 18.43C20.74 17.36 21 16.21 21 15C21 10.03 16.97 6 12 6H12ZM12 19V21L16 17L12 13V15C8.13 15 5 11.87 5 8C5 7.65 5.03 7.3 5.09 6.96L3.7 5.57C3.26 6.64 3 7.79 3 9C3 13.97 7.03 18 12 18H12Z" fill="currentColor"/>
            </svg>                          
        </i>
        <span class="item-name">Exchange</span>
        <i class="right-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </i>
    </a>
    <ul class="sub-nav collapse" id="sidebar-exchange" data-bs-parent="#sidebar">
    <li class="nav-item">
    <a class="nav-link" href="../cryptocoin_management/cryptocoin_list.php">
        <i class="icon">
        <svg width="10" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="1" width="11" height="11" stroke="currentColor"/>
                    </svg>                  
        </i>
        <i class="sidenav-mini-icon"> E </i>
        <span class="item-name">Currency</span>
    </a>
</li>

        <li class="nav-item">
            <a class="nav-link" href="../market_management/market_list.php">
                <i class="icon">
                    <svg width="10" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="1" width="11" height="11" stroke="currentColor"/>
                    </svg> 
                </i>
                <i class="sidenav-mini-icon"> M </i>
                <span class="item-name">Market</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../pairCoin_management/pairCoin_list.php">
                <i class="icon">
                    <svg width="10" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="1" width="11" height="11" stroke="currentColor"/>
                    </svg>
                </i>
                <i class="sidenav-mini-icon"> P </i>
                <span class="item-name">Pairs of coins</span>
            </a>
        </li>
    </ul>
</li>

<!-- Finance -->
<li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-finance" role="button" aria-expanded="false" aria-controls="sidebar-finance">
        <i class="icon">
            <svg width="22" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 4H20C20.55 4 21 4.45 21 5V11C21 11.55 20.55 12 20 12H4C3.45 12 3 11.55 3 11V5C3 4.45 3.45 4 4 4ZM2 5C2 3.9 2.9 3 4 3H20C21.1 3 22 3.9 22 5V11C22 12.1 21.1 13 20 13H4C2.9 13 2 12.1 2 11V5ZM2 16C2 14.9 2.9 14 4 14H20C21.1 14 22 14.9 22 16V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V16ZM20 16H4V18H20V16Z" fill="currentColor"/>
            </svg>
        </i>
        <span class="item-name">Finance</span>
        <i class="right-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </i>
    </a>
    <ul class="sub-nav collapse" id="sidebar-finance" data-bs-parent="#sidebar">
        <li class="nav-item">
            <a class="nav-link" href="../finance/add_credit.php">
                <i class="icon">
                    <svg width="10" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0.5" y="1" width="11" height="11" stroke="currentcolor"/>
                    </svg> 
                </i>
                <i class="sidenav-mini-icon"> L </i>
                <span class="item-name">Add Credit</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../finance/credit_list.php">
                <i class="icon">
                    <svg width="10" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0.5" y="1" width="11" height="11" stroke="currentcolor"/>
                    </svg> 
                </i>
                <i class="sidenav-mini-icon"> R </i>
                <span class="item-name">Credit List</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../finance/fees.php">
                <i class="icon">
                    <svg width="10" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0.5" y="1" width="11" height="11" stroke="currentcolor"/>
                    </svg> 
                </i>
                <i class="sidenav-mini-icon"> L </i>
                <span class="item-name">Fees</span>
            </a>
        </li>
        
       
    </ul>
</li>

<!-- Settings -->
<li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-settings" role="button" aria-expanded="false" aria-controls="sidebar-settings">
        <i class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
  <circle cx="12" cy="12" r="3"></circle>
  <path d="M19.4 15a1.8 1.8 0 0 0 .37 2l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.8 1.8 0 0 0-2-.37 1.8 1.8 0 0 0-1.05 1.61v.17a2 2 0 0 1-4 0v-.09a1.8 1.8 0 0 0-1.11-1.65 1.8 1.8 0 0 0-2 .37l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.8 1.8 0 0 0 .37-2 1.8 1.8 0 0 0-1.61-1.05h-.17a2 2 0 0 1 0-4h.09a1.8 1.8 0 0 0 1.65-1.11 1.8 1.8 0 0 0-.37-2l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.8 1.8 0 0 0 2-.37 1.8 1.8 0 0 0 1.05-1.61v-.17a2 2 0 0 1 4 0v.09a1.8 1.8 0 0 0 1.11 1.65 1.8 1.8 0 0 0 2-.37l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.8 1.8 0 0 0-.37 2c.27.4.64.74 1.05.94z"></path>
</svg>


        </i>
        <span class="item-name">Settings</span>
        <i class="right-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </i>
    </a>
    <ul class="sub-nav collapse" id="sidebar-settings" data-bs-parent="#sidebar">
        <li class="nav-item">
            <a class="nav-link" href="../settings/appSetting.php">
                <i class="icon">
                    <svg width="10" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0.5" y="1" width="11" height="11" stroke="currentcolor"/>
                    </svg> 
                </i>
                <i class="sidenav-mini-icon"> L </i>
                <span class="item-name">Application settings</span>
            </a>
        </li>          
    </ul>
</li>


        


                    <li class="nav-item">
                        <a class="nav-link " href="../dashboard/maps/google.html">
                            <i class="icon">
                                <svg width="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 10.5005C14.5 9.11924 13.3808 8 12.0005 8C10.6192 8 9.5 9.11924 9.5 10.5005C9.5 11.8808 10.6192 13 12.0005 13C13.3808 13 14.5 11.8808 14.5 10.5005Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9995 21C10.801 21 4.5 15.8984 4.5 10.5633C4.5 6.38664 7.8571 3 11.9995 3C16.1419 3 19.5 6.38664 19.5 10.5633C19.5 15.8984 13.198 21 11.9995 21Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>                            
                            </i>
                            <span class="item-name">Maps</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="../dashboard/icons/outline.html">
                            <i class="icon">
                                <svg width="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.739 6.15368C19.739 3.40281 17.8583 2.30005 15.1506 2.30005H8.79167C6.16711 2.30005 4.2002 3.32762 4.2002 5.97022V20.694C4.2002 21.4198 4.98115 21.877 5.61373 21.5221L11.9957 17.9422L18.3225 21.5161C18.9561 21.873 19.739 21.4158 19.739 20.689V6.15368Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                <path d="M8.27148 9.02811H15.5898" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                </svg>                            
                            </i>
                                <span class="item-name">icons</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="../dashboard/errors/error404.html">
                            <i class="icon">
                                <svg width="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.3955 9.59497L9.60352 14.387" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                <path d="M14.3971 14.3898L9.60107 9.59277" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3345 2.75024H7.66549C4.64449 2.75024 2.75049 4.88924 2.75049 7.91624V16.0842C2.75049 19.1112 4.63549 21.2502 7.66549 21.2502H16.3335C19.3645 21.2502 21.2505 19.1112 21.2505 16.0842V7.91624C21.2505 4.88924 19.3645 2.75024 16.3345 2.75024Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                </svg>                            
                            </i>
                            <span class="item-name">Error</span>
                        </a>
                    </li> 
                    <li><hr class="hr-horizontal"></li>
                    <li class="nav-item">
                        <a class="nav-link " href="../index.html" target="_blank">
                        <i class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </i>
                            <span class="item-name">Components</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " target="_blank" href="https://templates.iqonic.design/coinex/documentation/html/dist/main/">
                        <i class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                        </i>
                            <span class="item-name">Documentation</span>
                        </a>
                    </li>
                </ul>        </div>        
            <div id="sidebar-footer" class="position-relative sidebar-footer">
                <div class="card mx-4">
                    <div class="card-body">
                        <div class="sidebarbottom-content">
                            <div class="image">
                                <img src="../assets/images/coins/13.png" alt="User-Profile" class="img-fluid">
                            </div>
                            <p class="mb-0">Be more secure with Pro Feature</p>
                            <button type="button" class="btn btn-primary mt-3">Upgrade Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>