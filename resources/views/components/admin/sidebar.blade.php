@php
  $check_role=Session::get('admin');
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{URL::to('/admin/dashboard')}}" class="brand-link">
    <!-- <img src="{{asset('storage/yesvitelogo.png')}}" alt="Yesvite Logo" class="brand-image logo-full elevation-3" style="opacity: .8'">-->


    <span class="brand-image logo-full" style="opacity: .8'">
      <svg width="129" height="36" viewBox="0 0 129 36" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.86965 6.81981H8.48313C8.25473 6.80224 8.35136 6.58262 8.35136 6.58262C8.5007 6.23124 8.6149 6.09947 8.43042 5.95013C8.0966 5.68659 7.8155 5.3967 7.5871 5.08924C6.42753 3.52558 6.71742 1.58418 7.79793 0.837483C8.42163 0.407037 9.33524 0.407037 9.95894 0.837483C11.0395 1.58418 11.3206 3.52558 10.1698 5.08924C9.94137 5.3967 9.66905 5.68659 9.32645 5.95013C9.13319 6.09947 9.25617 6.22245 9.40551 6.58262C9.40551 6.58262 9.50214 6.79345 9.27374 6.81981H8.88722H8.86965Z" fill="#ECB015" />
        <path fill-rule="evenodd" clip-rule="evenodd" d="M25.9168 9.75338C25.9168 9.05061 26.1627 8.40934 26.5844 7.9174C27.1115 7.2849 27.9021 6.8896 28.7893 6.8896C30.3706 6.8896 31.6619 8.17215 31.6619 9.76217H34.6575C34.6575 6.52064 32.0309 3.89404 28.7893 3.89404C26.6986 3.89404 24.8714 4.98334 23.826 6.62606C23.7733 6.7139 23.7206 6.80175 23.6679 6.8896C23.1935 7.7417 22.9212 8.7168 22.9212 9.76217H25.9168V9.75338Z" fill="black" />
        <path fill-rule="evenodd" clip-rule="evenodd" d="M30.3552 22.1547C29.7227 27.5484 25.146 31.7299 19.5853 31.7299C14.0246 31.7299 9.3073 27.4255 8.78901 21.9175L12.013 21.3465L11.2663 17.1475L0.00439453 19.1416L0.751087 23.3406L4.57239 22.6642C5.45086 30.175 11.8373 35.9992 19.5853 35.9992C27.3333 35.9992 34.0009 29.9115 34.6509 22.1547C34.6861 21.733 34.7036 21.3114 34.7036 20.8809C34.7036 20.4505 34.6861 20.0464 34.6509 19.6423H30.3552C30.3992 20.0464 30.4255 20.4593 30.4255 20.8809C30.4255 21.3026 30.3992 21.733 30.3552 22.1547Z" fill="black" />
        <path fill-rule="evenodd" clip-rule="evenodd" d="M115.199 20.3698C115.199 24.4371 117.958 26.8968 121.955 26.8968C123.966 26.8968 126.048 26.0271 127.34 24.1384L124.335 23.0491C123.861 23.5937 123.018 23.9715 121.849 23.9715C120.461 23.9715 119.117 23.1282 118.994 21.3888H128.104C128.35 17.0404 125.846 13.9395 121.797 13.9395C118.195 13.9395 115.19 16.4431 115.19 20.3698H115.199ZM121.902 16.7417C123.369 16.7417 124.555 17.5587 124.608 19.1487H118.994C119.214 17.4621 120.488 16.7417 121.902 16.7417Z" fill="black" />
        <path fill-rule="evenodd" clip-rule="evenodd" d="M105.518 17.1664H107.556V23.1224C107.556 26.0301 108.602 26.6011 111.624 26.6011H114.004V23.5265H112.915C111.703 23.5265 111.325 23.3069 111.325 22.1385V17.1752H114.004V14.2939H111.325V11.2192H107.548V14.2939H105.51V17.1752L105.518 17.1664Z" fill="black" />
        <path fill-rule="evenodd" clip-rule="evenodd" d="M102.208 12.2458C103.447 12.2458 104.44 11.2268 104.44 10.0145C104.44 8.80222 103.447 7.7832 102.208 7.7832C100.97 7.7832 99.9771 8.77586 99.9771 10.0145C99.9771 11.2531 100.97 12.2458 102.208 12.2458Z" fill="black" />
        <path fill-rule="evenodd" clip-rule="evenodd" d="M97.9688 17.1636H100.306V26.5983H104.1V14.2822H97.9688V17.1636Z" fill="black" />
        <path fill-rule="evenodd" clip-rule="evenodd" d="M88.2859 26.5983H92.5288L96.9475 14.2822H93.0559L90.4205 22.6715L87.7939 14.2822H83.8936L88.2859 26.5983Z" fill="black" />
        <path fill-rule="evenodd" clip-rule="evenodd" d="M77.1936 26.8968C80.4966 26.8968 83.2286 25.4824 83.2286 22.5747C83.2286 20.5103 81.8407 19.6494 78.8627 19.096L76.5787 18.6744C75.4894 18.4723 75.0677 18.1824 75.0677 17.6817C75.0677 17.0404 75.7617 16.689 77.1058 16.689C78.2214 16.689 79.1701 16.935 79.4161 17.831L82.5961 16.6627C81.6738 14.7301 79.4952 13.9307 77.1321 13.9307C74.0751 13.9307 71.4748 15.2484 71.4748 17.831C71.4748 19.8954 73.1175 21.1077 75.4982 21.503L77.7031 21.872C79.1174 22.1179 79.6182 22.4693 79.6182 22.9876C79.6182 23.7606 78.5025 24.1296 77.2814 24.1296C75.8671 24.1296 74.7515 23.6289 74.3737 22.5923L71.1674 23.7607C72.1073 25.825 74.321 26.888 77.2024 26.888L77.1936 26.8968Z" fill="black" />
        <path fill-rule="evenodd" clip-rule="evenodd" d="M57.18 20.3698C57.18 24.4371 59.9384 26.8968 63.9354 26.8968C65.947 26.8968 68.029 26.0271 69.3203 24.1384L66.316 23.0491C65.8416 23.5937 64.9983 23.9715 63.8299 23.9715C62.442 23.9715 61.0979 23.1282 60.9749 21.3888H70.0846C70.3306 17.0404 67.8269 13.9395 63.7772 13.9395C60.1755 13.9395 57.1712 16.4431 57.1712 20.3698H57.18ZM63.8826 16.7417C65.3497 16.7417 66.5356 17.5587 66.5883 19.1487H60.9749C61.1946 17.4621 62.4683 16.7417 63.8826 16.7417Z" fill="black" />
        <path fill-rule="evenodd" clip-rule="evenodd" d="M43.9792 14.2822L48.6965 26.5192L48.5735 26.8442C48.2046 27.7842 47.9323 27.8632 46.3422 27.8632H45.5956V30.5953H46.8078C50.0142 30.5953 50.9278 29.7256 52.1225 26.5983L56.8399 14.2822H52.7902L50.4359 21.9776L48.0289 14.2822H43.9792Z" fill="black" />
        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.12968 9.63483C3.36687 9.67875 3.32295 9.83688 3.3493 10.2234C3.3493 10.2234 3.36687 10.4518 3.5777 10.364L3.72704 10.2849L6.16038 15.2658H6.22187L6.27458 15.2394L3.83245 10.2322L3.77975 10.2585L3.98179 10.1619C4.17505 10.0477 4.00815 9.89837 4.00815 9.89837C3.72704 9.64361 3.56891 9.58212 3.67433 9.36251C3.86759 8.98477 3.99936 8.60703 4.06964 8.24686C4.45616 6.36695 3.39322 4.7418 2.11067 4.52218C1.7505 4.46069 1.38154 4.50461 1.01259 4.68909C-0.91124 5.64661 -0.0327782 9.06383 3.12968 9.63483Z" fill="#3ABEEA" />
        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.31463 9.63483C9.07745 9.67875 9.12137 9.83688 9.09502 10.2234C9.09502 10.2234 9.07745 10.4518 8.86662 10.364L8.71728 10.2849L6.28394 15.2658H6.22245L6.16974 15.2394L8.61186 10.2322L8.66457 10.2585L8.46252 10.1619C8.26926 10.0477 8.43617 9.89837 8.43617 9.89837C8.71728 9.64361 8.8754 9.58212 8.76998 9.36251C8.57672 8.98477 8.44495 8.60703 8.37468 8.24686C7.98815 6.36695 9.05109 4.7418 10.3336 4.52218C10.6938 4.46069 11.0628 4.50461 11.4317 4.68909C13.3556 5.64661 12.4771 9.06383 9.31463 9.63483Z" fill="#27B076" />
        <path opacity="0.21" fill-rule="evenodd" clip-rule="evenodd" d="M8.10115 3.07294C8.21535 2.9763 8.46131 3.08172 8.66336 3.31012C8.85662 3.53852 8.9269 3.80206 8.8127 3.89869C8.6985 3.99532 8.45253 3.8899 8.25048 3.6615C8.05722 3.4331 7.98695 3.16957 8.10115 3.07294Z" fill="white" />
        <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M8.51964 4.21417C8.57235 4.17025 8.68655 4.21417 8.7744 4.31959C8.86224 4.425 8.89738 4.54799 8.84468 4.59191C8.79197 4.63584 8.67777 4.59191 8.58992 4.4865C8.50208 4.38108 8.47572 4.2581 8.51964 4.21417Z" fill="white" />
        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.02645 6.30565H5.63993C5.41153 6.28808 5.50816 6.06846 5.50816 6.06846C5.6575 5.71708 5.7717 5.58531 5.58722 5.43597C5.2534 5.17243 4.9723 4.88254 4.7439 4.57508C3.58433 3.01142 3.87422 1.07002 4.95473 0.323323C5.57843 -0.107123 6.49203 -0.107123 7.11574 0.323323C8.19625 1.07002 8.47736 3.01142 7.32657 4.57508C7.09817 4.88254 6.82585 5.17243 6.48325 5.43597C6.28999 5.58531 6.41297 5.70829 6.56231 6.06846C6.56231 6.06846 6.65894 6.27929 6.43054 6.30565H6.04402H6.02645Z" fill="#ECB015" />
        <path d="M6.32789 10.9731H6.22247V15.2688H6.32789V10.9731Z" fill="#ECB015" />
        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.28744 9.54549C4.88479 10.0462 5.47336 10.4854 5.92138 10.8105C6.17613 11.0037 6.02679 11.1706 5.84232 11.645C5.84232 11.645 5.72812 11.9261 6.02679 11.9525H6.63293C6.94039 11.9349 6.81741 11.645 6.81741 11.645C6.62415 11.1706 6.47481 11.0037 6.73835 10.8105C7.18636 10.4854 7.77493 10.0462 8.37228 9.54549C9.26832 8.78123 10.2522 7.85884 10.7705 6.7959C12.176 3.9409 9.48793 -0.012174 6.33425 2.46509C3.18058 -0.012174 0.483699 3.9409 1.88924 6.7959C2.40753 7.85006 3.40019 8.78123 4.29622 9.54549H4.28744Z" fill="#EA555C" />
      </svg>
    </span>

  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset('assets/admin/assets/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image'">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-4">

      @if($check_role['role']=='admin')
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{URL::to('/admin/dashboard')}}" class="nav-link {{ (Request::segment(2) == 'dashboard')? 'active':'' }}">
            <i class="fas fa-tachometer-alt nav-icon"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <p class="asideTitle">Design Template</p>
          <ul class="pl-0">
            <li class="nav-item {{ (Request::segment(2) == 'category' || Request::segment(2) == 'subcategory' || Request::segment(2) == 'create_template' || Request::segment(2) == 'design_style')? 'menu-open':'' }}">
              <a href="#" class="nav-link  {{ (Request::segment(2) == 'category' || Request::segment(2) == 'subcategory' || Request::segment(2) == 'design_style'  }}">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Category Setup
                  <i class="fas fa-angle-right right"></i>
                  <!-- <span class="badge badge-info right">6</span> -->
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{URL::to('/admin/category')}}" class="nav-link  {{ (Request::segment(2) == 'category')? 'active':'' }}">
                    <span class="dot"></span>
                    <p>Category</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{URL::to('/admin/subcategory')}}" class="nav-link {{ (Request::segment(2) == 'subcategory')? 'active':'' }}">
                    <span class="dot"></span>
                    <p>Sub Category</p>
                  </a>
                </li>
                <!-- <li class="nav-item">
                  <a href="{{URL::to('/admin/design_style')}}" class="nav-link {{ (Request::segment(2) == 'design_style')? 'active':'' }}">
                    <span class="dot"></span>
                    <p>Design Style</p>
                  </a>
                </li> -->
                {{-- <li class="nav-item">
                  <a href="{{URL::to('/admin/create_template')}}" class="nav-link {{ (Request::segment(2) == 'create_template')? 'active':'' }}">
                    <span class="dot"></span>
                    <p>Create Template</p>
                  </a>
                </li> --}}

              </ul>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/admin/create_template')}}" class="nav-link {{ (Request::segment(2) == 'create_template')? 'active':'' }}">
                <i class="fas fa-layer-group"></i>
                <p>
                  Create Template
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{URL::to('/admin/event_type')}}" class="nav-link {{ (Request::segment(2) == 'event_type')? 'active':'' }}">
                <i class="fas fa-layer-group"></i>
                <p>
                  Event Type
                </p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <p class="asideTitle">User Management</p>
          <ul class="nav">
            <li class="nav-item">
              <a href="{{URL::to('/admin/users')}}" class="nav-link {{ (Request::segment(2) == 'users')? 'active':'' }}">
                <i class="fas fa-users nav-icon"></i>
                <p>Users</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/admin/professional_users')}}" class="nav-link {{ (Request::segment(2) == 'professional_users')? 'active':'' }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Professional Users</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/admin/account_verification')}}" class="nav-link {{ (Request::segment(2) == 'account_verification')? 'active':'' }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Account Verification</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/admin/user_resend_verification')}}" class="nav-link {{ (Request::segment(2) == 'user_resend_verification')? 'active':'' }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Expired Verification Emails</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/admin/user_post_report')}}" class="nav-link {{ (Request::segment(2) == 'user_post_report')? 'active':'' }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Users Post Reports</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/admin/user_chat_report')}}" class="nav-link {{ (Request::segment(2) == 'user_chat_report')? 'active':'' }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Users Chat Reports</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/admin/sendNotification')}}" class="nav-link {{ (Request::segment(3) == 'sendNotification')? 'active':'' }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Send Notification</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/admin/login_history')}}" class="nav-link {{ (Request::segment(2) == 'login_history')? 'active':'' }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Login History</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <p class="asideTitle">Event management</p>
          <ul class="nav">
            <li class="nav-item">
              <a href="{{URL::to('/admin/events')}}" class="nav-link {{ (Request::segment(2) == 'events')? 'active':'' }}">
                <i class="fas fa-list nav-icon"></i>
                <p>Event Lists</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <p class="asideTitle">Privacy & Terms</p>
          <ul class="pl-0">
              <li
                  class="nav-item {{ Request::segment(2) == 'privacy_policy' || Request::segment(2) == 'terms_condition' ? 'menu-open' : '' }}">
                  <a href="#"
                      class="nav-link  {{ Request::segment(2) == 'privacy_policy' || Request::segment(2) == 'terms_condition' ? 'active' : '' }}">
                      <i class="nav-icon fas fa-copy"></i>
                      <p>
                          Privacy Setup
                          <i class="fas fa-angle-right right"></i>
                          <!-- <span class="badge badge-info right">6</span> -->
                      </p>
                  </a>
                  <ul class="nav nav-treeview">
                      <li class="nav-item">
                          <a href="{{ URL::to('/admin/privacy_policy') }}"
                              class="nav-link  {{ Request::segment(2) == 'privacy_policy' ? 'active' : '' }}">
                              <span class="dot"></span>
                              <p>Privacy Policy</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ URL::to('/admin/terms_condition') }}"
                              class="nav-link {{ Request::segment(2) == 'terms_condition' ? 'active' : '' }}">
                              <span class="dot"></span>
                              <p>Terms & Condition </p>
                          </a>
                      </li>


                  </ul>
              </li>



          </ul>
      </li>  

      
      <li class="nav-item">
        <p class="asideTitle">Roles</p>
        <ul class="nav">
          <li class="nav-item">
            <a href="{{URL::to('/admin/roles')}}" class="nav-link {{ (Request::segment(2) == 'roles')? 'active':'' }}">
              <i class="fas fa-list nav-icon"></i>
              <p>Roles List</p>
            </a>
          </li>
        </ul>
      </li>


      {{-- <li class="nav-item">
        <ul class="nav">
            <li class="nav-item">
                <a href="{{ URL::to('/admin/faq') }}"
                    class="nav-link {{ Request::segment(2) == 'faq' ? 'active' : '' }}">
                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                    <p>FAQ</p>
                </a>
            </li>
        </ul>F
    </li> --}}


    <li class="nav-item">
      <p class="asideTitle">FAQ</p>
      <ul class="nav">
        <li class="nav-item">
          <a href="{{ URL::to('/admin/faq') }}"
          class="nav-link {{ Request::segment(2) == 'faq' ? 'active' : '' }}">
          <i class="fa fa-question-circle" aria-hidden="true"></i>
          <p>FAQ</p>
      </a>
        </li>
      </ul>
    </li>
        <!-- <li class="nav-item">
            <a href="{{URL::to('/admin/users')}}" class="nav-link {{ (Request::segment(2) == 'users')? 'active':'' }}">
              <i class="fas fa-users nav-icon"></i>
              <p>Users</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{URL::to('/admin/professional_users')}}" class="nav-link {{ (Request::segment(2) == 'professional_users')? 'active':'' }}">
              <i class="fas fa-user-tie nav-icon"></i>
              <p>Professional Users</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{URL::to('/admin/event_lists')}}" class="nav-link {{ (Request::segment(2) == 'event_lists')? 'active':'' }}">
              <i class="fas fa-list nav-icon"></i>
              <p>Event Lists</p>
            </a>
          </li> -->




        <!-- <li class="nav-item menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{URL::to('/admin')}}" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard v1</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./index2.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard v2</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./index3.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard v3</p>
              </a>
            </li>
          </ul>
        </li> -->

      </ul>
      {{-- @elseif ($check_role['role']=="designer"||$check_role['role']=="Designer") --}}
      @else
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <p class="asideTitle">Design Template</p>
          <ul class="pl-0">
            <li class="nav-item {{ (Request::segment(2) == 'category' || Request::segment(2) == 'subcategory' || Request::segment(2) == 'create_template' || Request::segment(2) == 'design_style')? 'menu-open':'' }}">
              <a href="#" class="nav-link  {{ (Request::segment(2) == 'category' || Request::segment(2) == 'subcategory' || Request::segment(2) == 'design_style' || Request::segment(2) == 'create_template')? 'active':'' }}">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Category Setup
                  <i class="fas fa-angle-right right"></i>
                  <!-- <span class="badge badge-info right">6</span> -->
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{URL::to('/admin/category')}}" class="nav-link  {{ (Request::segment(2) == 'category')? 'active':'' }}">
                    <span class="dot"></span>
                    <p>Category</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{URL::to('/admin/subcategory')}}" class="nav-link {{ (Request::segment(2) == 'subcategory')? 'active':'' }}">
                    <span class="dot"></span>
                    <p>Sub Category</p>
                  </a>
                </li>
                <!-- <li class="nav-item">
                  <a href="{{URL::to('/admin/design_style')}}" class="nav-link {{ (Request::segment(2) == 'design_style')? 'active':'' }}">
                    <span class="dot"></span>
                    <p>Design Style</p>
                  </a>
                </li> -->
                <li class="nav-item">
                  <a href="{{URL::to('/admin/create_template')}}" class="nav-link {{ (Request::segment(2) == 'create_template')? 'active':'' }}">
                    <span class="dot"></span>
                    <p>Create Template</p>
                  </a>
                </li>

              </ul>
            </li>
            <!-- <li class="nav-item">
              <a href="{{URL::to('/admin/design')}}" class="nav-link {{ (Request::segment(2) == 'design')? 'active':'' }}">
                <i class="fas fa-layer-group"></i>
                <p>
                  Design
                </p>
              </a>
            </li> -->
{{-- 
            <li class="nav-item">
              <a href="{{URL::to('/admin/event_type')}}" class="nav-link {{ (Request::segment(2) == 'event_type')? 'active':'' }}">
                <i class="fas fa-layer-group"></i>
                <p>
                  Event Type
                </p>
              </a>
            </li> --}}
          </ul>
        </li>
        <ul>
          @endif
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>