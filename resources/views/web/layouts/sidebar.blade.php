<div class="sidebar col-sm-3 col-xl-2 mb-5">

  <div class="sidebar-sample mb-5 sidebar__item__active">
    <a href="{{ route('admin.store.index') }}"
       class="border-color-light-blue">{{ auth()->guard('admin')->user()->store->name }}店舗</a>
    {{--    <small class="text text-muted">{{ auth()->guard('admin')->user()->store->email }}</small>--}}
  </div>
  <div class="vertical-menu" id="leftMenu">
    <a href="#" class="sidebar__item dropdown-sidebar border-color-blue">入荷・在庫登録</a>
    <div class="dropdown-sidebar-child">
      <a class="border-color-light-blue" href="{{ route('admin.product.index') }}">入荷登録</a>
    </div>
    <a href="#" class="sidebar__item dropdown-sidebar border-color-blue">在庫登録可否</a>
    <div class="dropdown-sidebar-child">
      <a class="border-color-light-blue" href="{{ route('admin.product.progress') }}">可否進捗</a>
    </div>
    <a href="#" class="sidebar__item dropdown-sidebar border-color-blue">受注確認</a>
    <div class="dropdown-sidebar-child">
      <a class="border-color-light-blue" href="{{ route('admin.order.progress') }}">受注進捗</a>
      <a class="border-color-light-blue" href="{{ route('admin.order.remaining') }}">受注残確認</a>
    </div>
    <a href="#" class="sidebar__item dropdown-sidebar border-color-blue">注文請負</a>
    <div class="dropdown-sidebar-child">
      <a class="border-color-light-blue" href="#">請求状況</a>
      <a class="border-color-light-blue" href="#">納品状況</a>
    </div>
    <a href="#" class="sidebar__item dropdown-sidebar border-color-blue">メッセージ<span
        class="badge badge-danger">2</span></a>
    <div class="dropdown-sidebar-child">
      <a class="border-color-light-blue" href="#">新着メッセージ</a>
      <a class="border-color-light-blue" href="#">メール作成</a>
    </div>
    <a href="#" class="sidebar__item dropdown-sidebar border-color-blue">管理</a>
    <div class="dropdown-sidebar-child ">
      <a class="border-color-light-blue" href="#">元帳</a>
      <a class="border-color-light-blue" href="#">残高一覧</a>
      <a class="border-color-light-blue" href="#">入出金明細</a>
      <a class="border-color-light-blue" href="#">売上・仕入照合</a>
    </div>
  </div>
</div>
