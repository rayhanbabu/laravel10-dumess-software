<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="MD Rayhan Babu" />
    <title>Manager Panel</title>
    <link rel="icon" type="image/png" href="{{asset('images/ancovabr.png')}}">
  

    <link rel="stylesheet" href="{{asset('dashboardfornt/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('dashboardfornt/css/dataTables.bootstrap5.min.css')}}">
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <link rel='stylesheet'
     href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />

    
     
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

    <script src="{{asset('dashboardfornt\js\jquery-3.5.1.js')}}"></script>
    <script src="{{asset('dashboardfornt\js\bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('dashboardfornt\js\jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('dashboardfornt\js\dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('dashboardfornt/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('dashboardfornt/js/scripts.js')}}"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
  
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"  />
          <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" ></script>
  
   

</head>

 
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-primary text-white">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3 text-white"  href="#" >ANCOVA </a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order order-lg-0 me-4 me-lg-0 text-white" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                      {{ manager_info()['manager_name'] }} ,  {{ manager_info()['hall_name'] }}
                </div>
            </form>
            <!-- Navbar-->
           
           

          <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="{{ url('manager/password')}}">Password Change</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="{{ url('manager/logout')}}">Logout</a></li>
                    </ul>
                </li>
            </ul>
         </nav>


<div id="layoutSidenav">
  <div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
     <div class="sb-sidenav-menu">
       <div class="nav">
                           					   
     <a class="nav-link @yield('dashboard')" href="{{url('manager/dashboard')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
          Dashboard
     </a>

    
        <a class="nav-link @yield('member1')" href="{{url('manager/member/1')}}">
           <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
            Member view
         </a>
  

     @if(booking_access())
     <a class="nav-link @yield('Life_Member_select') @yield('Member_select')  @yield('Executive_select')
      collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts1" aria-expanded="false" aria-controls="collapseLayouts1">
      <div class="sb-nav-link-icon "><i class="fas fa-columns"></i></div>
            Seat Booking
         <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
      </a>
      <div class="collapse" id="collapseLayouts1" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link @yield('booking0')" href="{{url('/manager/booking/0')}}">Pending </a>
                <a class="nav-link @yield('booking2')" href="{{url('/manager/booking/2')}}">Pre-Booked </a>
                <a class="nav-link @yield('booking1')" href="{{url('/manager/booking/1')}}">Booked  </a>
                <a class="nav-link @yield('booking5')" href="{{url('/manager/booking/5')}}">Resign  </a>
        </nav>
      </div>
      @else
           @endif   


  @if(booking_access())
    <a class="nav-link @yield('Life_Member_select') @yield('Member_select')  @yield('Executive_select')
    collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
     <div class="sb-nav-link-icon "><i class="fas fa-columns"></i></div>
            Booking Info
       <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
     </a>
     <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
          <nav class="sb-sidenav-menu-nested nav">
             <a class="nav-link @yield('Building_select')" href="{{url('/manager/building_view')}}">Bulidings </a>
             <a class="nav-link @yield('Room_select')" href="{{url('/manager/room_view')}}">Rooms </a>
             <a class="nav-link @yield('Seat_select')" href="{{url('/manager/seat_view')}}">Seats  </a>  
          </nav>
       </div>
      @else
     @endif  


      @if(adminaccess())				
     <a class="nav-link @yield('information_update')" href="{{url('manager/information_update')}}">
         <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
            Section Update
     </a>
     @endif

     @if(adminauditoraccess())
     <a class="nav-link @yield('manager_access')" href="{{url('manager/manager_access')}}">
         <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
            Manager Access  
      </a>
      @endif

 
        <a class="nav-link @yield('section')" href="{{url('manager/sectioninfo')}}">
           <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Section Information
        </a>

         <a class="nav-link @yield('payment_link')" href="{{url('manager/payment_link')}}">
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Payment Link
         </a>

     <a class="nav-link @yield('withdraw')" href="{{url('manager/withdraw')}}">
         <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
             Settlement History
        </a>
  
					
       @if(manager_access_payment())	
          <a class="nav-link @yield('payment1')" href="{{url('manager/payment/1')}}">
            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
             Payment Summary
         </a>
         @endif
     
   
        <a class="nav-link @yield('mealsheet')" href="{{url('manager/mealsheet')}}">
           <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
            Meal Sheet
         </a>
 

     @if(application_access())
        <a class="nav-link @yield('appApplication')" href="{{url('manager/app/Application')}}">
           <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
            Application
         </a>

         <a class="nav-link @yield('appSession')" href="{{url('manager/app/Session')}}">
           <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
              Session 
         </a>

     @else
     @endif

     <a class="nav-link @yield('bazar')" href="{{url('manager/bazar')}}">
           <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
            Bazar Details
         </a>
         
     @if(bazar_access())
        <a class="nav-link @yield('product')" href="{{url('manager/product')}}">
           <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
              Product Details
         </a>
     @else
     @endif

     <a class="nav-link @yield('report')" href="{{url('manager/report')}}">
         <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
            Reports   
      </a>

       <a class="nav-link @yield('module_summary')" href="{{url('manager/module_summary')}}">
          <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
             Module Summary   
       </a>
  
       <a class="nav-link @yield('meeting')" href="{{url('manager/meeting')}}">
         <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
            Meeting Fee   
       </a>


    <a class="nav-link @yield('feedback')" href="{{url('manager/feedback')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
          Feedback   
    </a>

    <a class="nav-link @yield('resign')" href="{{url('manager/resign')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
          Resign View  
    </a>

    <a class="nav-link @yield('extra_payment')" href="{{url('manager/extra_payment')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
          Extra Payment  
    </a>

      <a class="nav-link @yield('managerlist')" href="{{url('manager/managerlist')}}">
           <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
           Manager List
         </a>

    @if(member_access())
        <a class="nav-link @yield('member5')" href="{{url('manager/member/5')}}">
           <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
            Ex-Member View
         </a>
     @else
     @endif


     @if(manager_access_payment())
        <a class="nav-link @yield('payment5')" href="{{url('manager/ex_payment/5')}}">
           <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
             Last Invoice
         </a>
     @else
     @endif


  </div>
 </div>
                   
 
 
<div class="sb-sidenav-footer">
     <div class="small"> developed by:</div>
          ANCOVA
      </div>
   </nav>
</div>



<div id="layoutSidenav_content">
<main>

<div class="container-fluid px-3">
      <div>
     @yield('content')
     </div>
</div>    

    </main>
               
            </div>
        </div> 

       
  

        
    
    </body>
</html>
