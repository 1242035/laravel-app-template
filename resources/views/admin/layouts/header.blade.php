<script src="{{ asset('js/popper.min.js') }}"></script>

<style>
    .dropdown {
        position: absolute;
        right: 10px;
        top: 0;
        min-width: 200px;
        text-align: right
    }

    .dropdown-menu {
        top: 10px !important;
        text-align: center;
        min-width: 200px;
    }

    .dropdown-toggle {
        cursor: pointer;
    }

    .dropdown-item {
        padding: 0px;
    }
    .dropdown-right {
        left: auto !important; 
        right: 0px !important;
    }
</style>
<div class="header">
    <div class="header__title position-relative text-center d-flex d-flex-between">
        <div class="d-flex">
            <a href="{{ route('admin.home') }}" class="text-white">
                <img class="text-white mt-n3" style="height:50px" src="{{ asset('images/logo/logo.svg') }}" alt="" />
            </a>
            <a href="{{ route('admin.home') }}"><span class="header__title__sub">管理者ページ</span></a>
        </div>
        @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
            <div class="dropdown">
                <div>
                    <span class="dropdown-toggle"
                          data-toggle="dropdown">{{(Auth::guard('admin')->user()->name) ? Auth::guard('admin')->user()->name: Auth::guard('admin')->user()->email}}</span>
                    <div class="dropdown-menu p-0 m-0 dropdown-right">
                        <a class="dropdown-item" href="{{route('admin.logout')}}">ログアウト</a>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
        @endif
    </div>

</div>
