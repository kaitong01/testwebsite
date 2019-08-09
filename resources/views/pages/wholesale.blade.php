@extends('index')

@section('title', 'โฮเซลล์')

@section('content')


<div class="layout__box o__flexes-to-1 o__has-columns">

    {{-- navleft --}}
    <div class="layout__box o__has-columns">

        <div class="navleft layout__box o__has-rows">

            <div class="navleft-header p-3 layout__box">
                <h1 class="navleft-header-title">โฮเซลล์</h1>
            </div>

            <div class="navleft-sections layout__box">

                <ul class="navleft-nav">


                    <li class="navleft-item is-open">
                        <a href="#" class="navleft-link navleft-title">

                            <span class="navleft-text">User auto messages</span>
                            <span class="navleft-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path d="M7.25 4L6 5.114l2.663 2.887L6 10.886 7.25 12 11 8.001z"></path></svg></span>
                        </a>
                        <div class="navleft-dropdown">
                            <ul class="navleft-sub">

                                <li class="navleft-item">
                                    <a href="#" class="navleft-link">
                                        <span class="navleft-text">Messages</span>
                                        <span class="navleft-count">27</span>
                                    </a>
                                </li>

                                <li class="navleft-item">
                                    <a  href="#" class="navleft-link d-flex">
                                        <span class="navleft-text">Campaigns</span>
                                        <span class="navleft-count">27</span>
                                    </a>
                                </li>
                                <li class="navleft-item">
                                    <a  href="#" class="navleft-link d-flex">
                                        <span class="navleft-text">Folders</span>
                                        <span class="navleft-count">27</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>


                    <li class="navleft-item">
                            <a href="#" class="navleft-link navleft-title">

                                <span class="navleft-text">User auto messages</span>
                                <span class="navleft-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path d="M7.25 4L6 5.114l2.663 2.887L6 10.886 7.25 12 11 8.001z"></path></svg></span>
                            </a>

                            <div class="navleft-dropdown">
                                <ul class="navleft-sub">

                                    <li class="navleft-item">
                                        <a href="#" class="navleft-link">
                                            <span class="navleft-text">Messages</span>
                                            <span class="navleft-count">27</span>
                                        </a>
                                    </li>

                                    <li class="navleft-item">
                                        <a  href="#" class="navleft-link d-flex">
                                            <span class="navleft-text">Campaigns</span>
                                            <span class="navleft-count">27</span>
                                        </a>
                                    </li>
                                    <li class="navleft-item">
                                        <a  href="#" class="navleft-link d-flex">
                                            <span class="navleft-text">Folders</span>
                                            <span class="navleft-count">27</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                </ul>

            </div>
        </div>

    </div>
    {{-- end: navleft --}}

    <div class="layout__box o__has-rows o__flexes-to-1">



        {{-- Datalist --}}
        <div class="page-datalist">

            {{-- Datalist -> Header --}}
            <div class="page-datalist-header layout__box fixed">
                <div class="pt-3 px-3">

                    {{-- Header -> top --}}
                    <div class="layout__box d-flex justify-content-between mb-2">

                        <div class="d-flex">
                            {{-- title --}}
                            <div style="margin-right: 8px;padding-right: 15px;border-right: 1px solid #ddd">
                                <h1 style="font-size: 22px;line-height: 1;font-weight: bold">โฮเซลล์</h1>
                                <span style="font-size: 12px;line-height: 1;color: #666">ผลลัพธ์ทั้งหมด <span ref="total">44</span> รายการ</span>
                            </div>
                            {{-- end: title --}}

                            <div>
                                <button type="button" class="btn btn-outline-secondary ml-2" data-action="refresh"><i class="fa fa-refresh"></i></button>
                            </div>
                        </div>

                        <div>
                            <a class="btn btn-primary ml-2" href="javascript:void(0)"><svg class="svg-icon o__tiny o__by-text" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg> <span>เพิ่ม</span></a>
                        </div>
                    </div>
                    {{-- end: Header -> top --}}

                    {{-- Header -> tabs --}}
                    <nav class="d-flex mb-2">
                        <div class="mr-auto mb-3">
                            <ul class="page-datalist-tabs nav">
                                <li class="nav-item active"><a href="#" class="nav-link"><span class="nav-text">ทั้งหมด</span><span class="nav-count">(0)</span></a></li>
                                <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">ใช้งาน</span><span class="nav-count">(0)</span></a></li>
                                <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">รอการตรวจสอบ</span><span class="nav-count">(0)</span></a></li>
                                <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">ระงับ</span><span class="nav-count">(0)</span></a></li>

                            </ul>
                        </div>

                        <div class="ml-auto">

                            <ul class="page-datalist-checkbox nav">
                                <li class="nav-item active">
                                    <label class="checkbox">
                                        <input type="checkbox" name="" value="" checked />
                                        <span class="text">ทั้งหมด</span>
                                        <span class="count">(0)</span>
                                    </label>

                                </li>
                            </ul>
                        </div>
                    </nav>
                    {{-- end: Header -> tabs --}}


                     {{-- Header -> tabs --}}
                     <nav class="page-datalist-filter d-flex mb-2">

                        <ul class="nav mr-auto">
                            <li class="nav-item filter-item">
                                <label class="filter-item-label" for="status">สถานะ:</label>
                                <select class="filter-item-input form-control" id="status" name="status" data-filter-action="change"><option value="">ทั้งหมด</option><option selected="" value="1">ใช้งาน</option><option value="2">รอติดต่อ</option><option value="0">ระงับ</option></select>
                            </li>

                        </ul>

                        <ul class="nav ml-auto">
                            <li class="nav-item filter-item">
                                <label class="filter-item-label" for="status">สถานะ:</label>
                                <select class="filter-item-input form-control" id="status" name="status" data-filter-action="change"><option value="">ทั้งหมด</option><option selected="" value="1">ใช้งาน</option><option value="2">รอติดต่อ</option><option value="0">ระงับ</option></select>
                            </li>

                            <li class="nav-item filter-item">
                                <label class="filter-item-label" for="status">สถานะ:</label>
                                <select class="filter-item-input form-control" id="status" name="status" data-filter-action="change"><option value="">ทั้งหมด</option><option selected="" value="1">ใช้งาน</option><option value="2">รอติดต่อ</option><option value="0">ระงับ</option></select>
                            </li>

                            <li class="nav-item filter-item">
                                <input type="search" class="filter-item-input w form-control" id="search-input" placeholder="ค้นหา..." autocomplete="off" role="combobox" value="">
                            </li>

                            <li class="nav-item">
                                <button type="button" class="filter-item-btn btn btn-primary"><span>ค้นหา</span></button>
                            </li>

                        </ul>


                    </nav>

                    {{-- end: Header -> tabs --}}


                    <div class="page-datalist-header-table__fixed" style="border-bottom: 1px solid rgba(0,0,0,.1)">
                        <table class="datatable"><tbody><tr class="o__fixed-header"><th class="td-seq" style="width: 48px;"><span><span class="text">#</span></span></th><th class="td-name active"><a href="javascript:void(0)" data-action="sort" data-sort="co_name"><svg class="svg-icon" width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M15.993 12.994H4.585s.286-3.242 4.567-3.958C8.453 8.319 7.88 7.477 7.88 6.08c0-.913.036-3.08 2.454-3.08 2.328 0 2.436 2.167 2.436 3.08 0 1.397-.592 2.293-1.272 2.956 4.388 1.02 4.549 3.868 4.495 3.958zM3.707 13H0s.698-2.245 3.42-2.944c-.519-.447-.913-.985-.913-2.006 0-.644.18-2.238 1.773-2.238 1.576 0 1.738 1.665 1.738 2.31 0 1.021-.448 1.415-.735 1.791-.752.663-1.164 1.361-1.36 1.863-.305.77-.216 1.224-.216 1.224z" fill-rule="evenodd"></path></svg><span class="text">ชื่อ</span><svg class="sort svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path d="M8 8.196L11.607 5 13 6.5 8 11 3 6.5 4.393 5z"></path></svg></a></th><th class="td-status" style="width: 77px;"><span><span class="text">สถานะ</span></span></th><th class="td-date td-gray" style="width: 144px;"><a href="javascript:void(0)" data-action="sort" data-sort="co_updated"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path d="M3.643 3.196v-.714c0-.714.429-1.143 1.196-1.143.732 0 1.179.446 1.179 1.143v.714h.804v-.714c0-.696.464-1.143 1.196-1.143s1.179.446 1.179 1.143v.714h.821v-.714c0-.696.446-1.143 1.179-1.143s1.196.446 1.196 1.143v.714h1.339V14.66H2.268V3.196h1.375zm.625-.714v1.893c0 .339.196.5.571.5.411 0 .554-.143.554-.5V2.482c0-.339-.179-.5-.554-.5s-.571.161-.571.5zm3.196 0v1.893c0 .357.143.5.554.5s.554-.143.554-.5V2.482c0-.339-.179-.5-.554-.5s-.554.161-.554.5zm3.179 0v1.893c0 .357.143.5.554.5.375 0 .571-.161.571-.5V2.482c0-.339-.196-.5-.571-.5s-.554.161-.554.5zm2.143 3.25H3.232v7.982h9.554V5.732zm-7.804 6.161l.107-.804c.393.143.768.214 1.107.214.5 0 .821-.25.821-.607 0-.446-.286-.643-1.196-.696v-.804c.661-.054.982-.268.982-.607 0-.286-.214-.429-.643-.429a2.02 2.02 0 0 0-.946.25l-.107-.804c.339-.161.786-.25 1.304-.25.911 0 1.5.429 1.5 1 0 .518-.339.893-1.018 1.125v.018c.768.214 1.143.589 1.143 1.143 0 .929-.821 1.464-1.946 1.464a2.84 2.84 0 0 1-1.107-.214zm5.714-4.464v4.607h-.982V8.625l-.821.304-.107-.804 1.411-.696h.5z"></path></svg><span class="text">แก้ไขล่าสุด</span><svg class="sort svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path d="M8 8.196L11.607 5 13 6.5 8 11 3 6.5 4.393 5z"></path></svg></a></th><th class="td-seq text-center" style="width: 108px;"><span><span class="text">แพ็คเกจทัวร์</span></span></th></tr></tbody></table>
                    </div>
                </div>

            </div>
            {{-- end: datalist -> Header --}}



            {{-- Datalist -> Body --}}
            <div class="page-datalist-body mx-3 mb-4">
                <div class="entity-list">
                    <table class="datatable">
                        <tbody>

                            <tr company-id="1"><td class="td-seq">1</td><td class="td-name active"><div class="row no-gutters"><div class="col"><div class="pl-2"><a class="font-weight-bold text-dark" href="javascript:void(0)" data-ref="name">KARAS WORLD TOURS </a><div class="layout__media ml-2"></div></div></div></div></td><td class="td-status"><div class="ui-status" style="background-color:#4CAF50">ใช้งาน</div></td><td class="td-date td-gray"><span data-ref="updated">13/09/2018 01:26</span></td><td class="td-seq text-center"><span data-ref="package_count">0</span></td></tr>
                        </tbody>

                    </table>


                </div>
            </div>
            {{-- end: Datalist -> Body --}}


            {{-- Datalist -> Alert --}}
            <div class="alert-state">

                <div class="loader-state">
                    <div class="loading__indicator o__small">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="loading__indicator__graphic">
                            <defs>
                            <linearGradient x1="28.154%" y1="63.74%" x2="74.629%" y2="17.783%" id="blueLoadingIndicatorGradient">
                                <stop stop-color="#286EFA" offset="0%"></stop>
                                <stop stop-color="#FFF" stop-opacity="0" offset="100%"></stop>
                            </linearGradient>
                            </defs>
                            <g transform="translate(2)" fill="none" fill-rule="evenodd">
                            <circle stroke="url(#blueLoadingIndicatorGradient)" stroke-width="4" cx="10" cy="12" r="10"></circle>
                            <path d="M10 2C4.477 2 0 6.477 0 12" stroke="#286EFA" stroke-width="4"></path>
                            <rect fill="#286EFA" x="8" width="4" height="4" rx="8"></rect>
                            </g>
                        </svg>
                    </div>
                </div>

                <div class="empty-state">
                    <div class="state-icon"><svg width="24" height="24" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H4V4h16v12z"></path><path d="M6 12h12v2H6zm0-3h12v2H6zm0-3h12v2H6z"></path></svg></div>
                    <h2 class="state-title">ไม่พบผลลัพธ์</h2>
                </div>


                <div class="error-state">
                        <div class="state-icon"><svg width="24" height="24" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H4V4h16v12z"></path><path d="M6 12h12v2H6zm0-3h12v2H6zm0-3h12v2H6z"></path></svg></div>

                        <h2 class="state-title">เกิดข้อผิดพลาด, ไม่สามารถเชื่อมต่อกับเซิฟเวอร์</h2>

                        <button class="btn btn-primary mt-3" role="button" data-action="tryagain" type="button">ลองอีกครั้ง…</button>
                    </div>


                <div class="more-state p-3">
                    <button class="btn btn-sm btn-primary" role="button" data-action="more" type="button">โหลดเพิ่ม…</button>
                </div>

            </div>


            {{-- end: Datalist -> Alert --}}




        </div>
        {{-- end: Datalist --}}

    </div>
</div>


@endsection



