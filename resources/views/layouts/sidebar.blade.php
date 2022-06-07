<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('template') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Salepos - App</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                {{-- menu master data --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('itemlist.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daftar Item</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('supplierlist.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daftar Supplier</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('costumerlist.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daftar Pelanggan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Data Lainnya
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('unitlist.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Daftar Satuan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('brandlist.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Daftra Merek</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('typelist.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Daftar Jenis</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('subtypelist.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Daftar Sub Jenis</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('banklist.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Daftar Bank</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('warehouselist.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Dept./Gudang</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                {{-- menu purchase --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>
                            Pembelian
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('purchaseorderlist.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pesanan Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('purchaselist.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Retur Pembelian</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- menu selling --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-luggage-cart"></i>
                        <p>
                            Penjualan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penjualan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Retur Penjualan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- menu stock --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Persediaan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Item Masuk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Item Keluar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Item Transfer</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- menu setting --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Pengaturan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Data User
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Daftar User</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user.profile', ['id' => Auth::id()]) }}) }}"
                                        class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Profile User</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengaturan Umum</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengaturan Perusahaan</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
@push('page-scripts')
    <script>
        var path = location.pathname.split('/')
        var url = '/' + path[1]
        // console.log(url);
        $('aside div.sidebar nav ul a').each(function() {
            if ($(this).attr('href').indexOf(url) !== -1) {
                $(this).addClass('active').parent().parent().addClass('menu-open').parent().addClass(
                        'active menu-open')
                    .parent().parent().addClass('menu-open').parent().addClass('active')
            }
        })
    </script>
@endpush
