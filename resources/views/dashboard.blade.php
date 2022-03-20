<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&display=swap"
        rel="stylesheet">
</head>
<body>
<div class="topbar transition">
    <div class="bars">
        <button type="button" class="btn transition" id="sidebar-toggle">
            <i class="las la-bars"></i>
        </button>
    </div>
    <!-- Navbar -->
    <div class="menu">
        <ul>
            <li>
                <a href="settings.html" class="transition">
                    <i class="las la-sign-out-alt">Logout</i>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="sidebar transition">
    <div class="logo">
        <a href="#">
            <p style="font-size: 24px; font-weight: bold; margin-bottom: 0; color: #07c53c !important;">Majoo</p>
        </a>
    </div>

    <!-- Sidebar Menu -->
    <div class="sidebar-items">
        <ul>
            <p class="menu">Navigation</p>
            <li>
                <a href="{{url("product")}}" class="transition active">
                    <i class="las la-home"></i>
                    <span>Product</span>
                </a>
            </li>
            <li>
                <a href="{{url("kategori")}}" class="transition">
                    <i class="lab la-chromecast"></i>
                    <span>Category</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="sidebar-overlay"></div>

<!-- Content -->
<div class="content transition">
    <div class="container-fluid dashboard">
        @yield("content")
    </div>
</div>

<div class="footer transition">
    <p>2019 &copy; PT Majoo Teknologi Indonesia </p>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-fixedheader/3.2.2/dataTables.fixedHeader.min.js" integrity="sha512-zDJy9VOvfaXGs/Zx56Hv5naXazh98keYmBXHpBVgn1QSn8nsWhO+7BUoI/4+lTcDFf/uJg7uwZ2K6Jdh6N7LoA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>

<script type="application/javascript">
    $(document).ready(function () {
        $("#sidebar-toggle, .sidebar-overlay").click(function () {
            $(".sidebar").toggleClass("sidebar-show");
            $(".sidebar-overlay").toggleClass("d-block");
        });
    });
</script>
