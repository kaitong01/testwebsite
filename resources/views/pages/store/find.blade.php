@extends('layouts.admin')
@section('title', 'คลังแพคเกจทัวร์')
@section('content')

<div style="background: linear-gradient(135deg,#e4e6f5,#ecf6ff 39%,#ddecff);background-size: 100% 302px;background-repeat: no-repeat;    padding-bottom: 56px;">
        <div class="business-settings-container" style="margin-left: auto;margin-right: auto">

        <div class="business-settings-header" style="background: transparent">

                <div class="d-flex">
                    <div>
                        <h1 class="title">คลังแพคเกจทัวร์</h1>
                    </div>

                </div>

                <form action="/store/find" method="get" class="row row-sm mt-2">
                    {{-- <div class="filter-item"><label for="status" class="filter-item-label">โฮลเซลล์:</label><select id="status" name="status" data-action="change" class="filter-item-input form-control"><option value="">ทั้งหมด</option><option value="1">ใช้งาน</option><option value="2">ระงับ</option></select></div> --}}

                    <div class="col">
                        <input type="text" autocomplete="off" role="combobox" name="q" class="form-control" placeholder="ค้าหา...">
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                    </div>
                </form>
            </div>


            <div class="business-settings-body">

                    <div class="store-product pt-3">
                      @if (!empty($data['data']))
                      <div class="store-product-section">

                          <div class="store-product-section-header d-flex justify-content-between align-items-center">
                              <div class="store-product-section-header-title">
                                  <h3>ทัวร์มาใหม่</h3>
                              </div>

                              <!-- <div><a href="/store/tours/new?sort=created_at&dir=desc"><span class="mr-1">ดูทั้งหมด</span><i class="fa fa-angle-right"></i></a></div> -->
                          </div>
                          <div class="store-product-section-body">
                              @component('components.product-grid', [
                                  'items' => $data['data']
                              ])

                              @endcomponent
                          </div>
                      </div>
                      @endif
                      {{-- end: pecent --}}

                    </div>
            </div>
        </div>
</div>



@endsection
