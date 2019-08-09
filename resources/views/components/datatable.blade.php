{{-- Datalist --}}
<div class="page-datalist" data-plugin="datatable"@if ( !empty( $options ) ) data-options="{{ Fn::stringify([
    "data" => '1111',
    "token" => csrf_token(),
]) }}"@endif>

    {{-- Datalist -> Header --}}
    <div class="page-datalist-header layout__box fixed">
        <div class="pt-3 px-3">

            {{-- Header -> top --}}
            <div class="layout__box d-flex justify-content-between mb-2">

                <div class="d-flex">
                    {{-- title --}}
                    <div style="margin-right: 8px;padding-right: 15px;border-right: 1px solid #ddd">
                        <h1 style="font-size: 22px;line-height: 1;font-weight: bold">{{ $title }}</h1>
                        <span style="font-size: 12px;line-height: 1;color: #666">ผลลัพธ์ทั้งหมด <span ref="total">0</span> รายการ</span>
                    </div>
                    {{-- end: title --}}

                    <div>
                        <button type="button" class="btn btn-outline-secondary ml-2" data-action="refresh"><i class="fa fa-refresh"></i></button>
                    </div>
                </div>


                <div>
                    @if ( !empty($actions_right) )

                    {{ $actions_right }}
                    @endif
                </div>
            </div>
            {{-- end: Header -> top --}}

            @if ( !empty($nav) || !empty($nav_right) )
            {{-- Header -> tabs --}}
            <nav class="page-datalist-nav d-flex" role="nav">

                @if ( !empty($nav) )
                <div class="mr-auto">{{ $nav }}</div>
                @endif

                @if ( !empty($nav_right) )
                <div class="ml-auto">{{ $nav_right }}</div>
                @endif

            </nav>
            {{-- end: Header -> tabs --}}
            @endif


            @if ( !empty($filter) || !empty($filter_right) )
            {{-- Header -> tabs --}}
            <nav class="page-datalist-filter d-flex" role="filter">

                @if ( !empty($filter) )
                <ul class="nav mr-auto">{{ $filter }}</ul>
                @endif

                @if ( !empty($filter_right) )
                <ul class="nav ml-auto">{{ $filter }}</ul>
                @endif

            </nav>
            @endif

            <div class="page-datalist-filter-result" role="filter__result"></div>

            {{-- end: Header -> tabs --}}
            <div class="page-datalist-header-table__fixed" role="table__fixed"></div>

        </div>

    </div>
    {{-- end: datalist -> Header --}}



    {{-- Datalist -> Body --}}
    <div class="page-datalist-body mx-3 mb-4">
        <div class="entity-list">
            <table class="datatable">
                <tbody role="results">{{ $results }}</tbody>
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
            @if ( !empty($state_icon) )
            <div class="state-icon">{{ $state_icon }}</div>
            @endif
            <h2 class="state-title">ไม่พบผลลัพธ์</h2>
        </div>


        <div class="error-state">
            @if ( !empty($state_icon) )
            <div class="state-icon">{{ $state_icon }}</div>
            @endif

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
