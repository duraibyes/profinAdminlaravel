@extends('platform.layouts.template')
@section('toolbar')
<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        @include('platform.layouts.parts._breadcrum')
    </div>
</div>
@endsection
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{ route('products.save') }}">

                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                    
                    <div class="card card-flush" id="product-thumbnail">
                        @include('platform.product.form.parts._thumbnail');
                    </div>
                    <div class="card card-flush" id="product-status">
                        @include('platform.product.form.parts._status');
                    </div>
                    <div class="card card-flush" id="product-is-featured">
                        @include('platform.product.form.parts._is_feature');
                    </div>
                    <div class="card card-flush" id="product-category">
                        @include('platform.product.form.parts._category');
                    </div>
                    
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Brand</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option" id="kt_ecommerce_add_product_store_template">
                                <option></option>
                                <option value="default" selected="selected">Default template</option>
                                <option value="electronics">Electronics</option>
                                <option value="office">Office stationary</option>
                                <option value="fashion">Fashion</option>
                            </select>
                        </div>
                    </div>
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Brochure</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="card card-flush py-4">
                               
                                <div class="card-body pt-0">
                                    <div class="fv-row mb-2">
                                        <div class="dropzone" id="kt_ecommerce_add_product_brochure">
                                            <div class="dz-message needsclick">
                                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                <div class="ms-4">
                                                    <h3 class="fs-5 fw-bolder text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                    <span class="fs-7 fw-bold text-gray-400">Upload up to 10 files</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
             
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin:::Tabs-->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_ecommerce_add_product_general">General</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_add_product_advanced">Descriptions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_add_product_advanced">Meta Tags</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_add_product_advanced">Related Products</a>
                        </li>
                    </ul>
                    <!--end:::Tabs-->

                    <div class="tab-content">
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <!--begin::General options-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>General</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Product Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="product_name" class="form-control mb-2" placeholder="Product name" value="" />
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>
                                            <!--end::Description-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-10 fv-row">
                                                    <label class="form-label">SKU</label>
                                                    <input type="text" name="product_name" class="form-control mb-2" placeholder="Product name" value="" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-10 fv-row">
                                                    <label class="form-label">Price</label>
                                                    <input type="text" name="product_name" class="form-control mb-2" placeholder="Product name" value="" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-10 fv-row">
                                                    <label class="form-label"><span>Price sale</span>
                                                    <a href="#" class="turn-on-schedule " >Choose Discount Period</a>
                                                    <a href="#" class="turn-off-schedule">Cancel</a>
                                                    
                                                    </label>
                                                    <input type="text" name="product_name" class="form-control mb-2" placeholder="Product name" value="" />
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row from_to_date" >
                                            <div class="col">
                                                <div class="fv-row mb-9">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-bold mb-2">Event Start Date</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-solid flatpickr-input active" name="calendar_event_start_date" placeholder="Pick a start date" id="kt_calendar_datepicker_product_start_date" />
                                                    <!--end::Input-->
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="fv-row mb-9">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-bold mb-2 required">Event End Date</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-solid" name="calendar_event_end_date" placeholder="Pick a end date" id="kt_calendar_datepicker_product_end_date" />
                                                    <!--end::Input-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" >
                                          
                                            <div class="col">
                                                <div class="col-md-3">
                                                    <label class="fs-6 fw-bold mb-2">Quantity</label>
                                                    <input type="number" class="form-control form-control-solid" name="qty" placeholder="Quantity" id="qty" />
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div>
                                            <label class="form-label">Short Description</label>
                                            <div id="kt_ecommerce_add_product_short_description" name="kt_ecommerce_add_product_short_description" class="min-h-200px mb-2"></div>
                                        </div>
                                        <br>
                                        <div>
                                            <label class="form-label">Long Description</label>
                                            <div id="kt_ecommerce_add_product_long_description" name="kt_ecommerce_add_product_long_description" class="min-h-200px mb-2"></div>
                                        </div>
                                        <br>
                                        <div>
                                            <label class="form-label">Technical specification</label>
                                            <div id="kt_ecommerce_add_product_technical_specification" name="kt_ecommerce_add_product_technical_specification" class="min-h-200px mb-2"></div>
                                        </div>
                                        <br>
                                        {{-- <div>
                                            <label class="form-label">Features</label>
                                            <div id="kt_ecommerce_add_product_features" name="kt_ecommerce_add_product_features" class="min-h-200px mb-2"></div>
                                        </div>
                                        <br>
                                        <div>
                                            <label class="form-label">Benefits</label>
                                            <div id="kt_ecommerce_add_product_benefits" name="kt_ecommerce_add_product_benefits" class="min-h-200px mb-2"></div>
                                        </div>
                                        <br>
                                        <div>
                                            <label class="form-label">Content</label>
                                            <div id="kt_ecommerce_add_product_content" name="kt_ecommerce_add_product_content" class="min-h-200px mb-2"></div>
                                        </div> --}}
                                       
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Card header-->
                                </div>
                                <!--end::General options-->
                                <!--begin::Media-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Media</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-2">
                                            <!--begin::Dropzone-->
                                            <div class="dropzone" id="kt_ecommerce_add_product_media">
                                                <!--begin::Message-->
                                                <div class="dz-message needsclick">
                                                    <!--begin::Icon-->
                                                    <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                    <!--end::Icon-->
                                                    <!--begin::Info-->
                                                    <div class="ms-4">
                                                        <h3 class="fs-5 fw-bolder text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                        <span class="fs-7 fw-bold text-gray-400">Upload up to 10 files</span>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                            </div>
                                            <!--end::Dropzone-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">Set the product media gallery.</div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Card header-->
                                </div>
                                <!--end::Media-->
                                <!--begin::Pricing-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Pricing</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Base Price</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="price" class="form-control mb-2" placeholder="Product price" value="" />
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Set the product price.</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold mb-2">Discount Type
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Select a discount type that will be applied to this product"></i></label>
                                            <!--End::Label-->
                                            <!--begin::Row-->
                                            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-1 row-cols-xl-3 g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
                                                <!--begin::Col-->
                                                <div class="col">
                                                    <!--begin::Option-->
                                                    <label class="btn btn-outline btn-outline-dashed btn-outline-default active d-flex text-start p-6" data-kt-button="true">
                                                        <!--begin::Radio-->
                                                        <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                            <input class="form-check-input" type="radio" name="discount_option" value="1" checked="checked" />
                                                        </span>
                                                        <!--end::Radio-->
                                                        <!--begin::Info-->
                                                        <span class="ms-5">
                                                            <span class="fs-4 fw-bolder text-gray-800 d-block">No Discount</span>
                                                        </span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col">
                                                    <!--begin::Option-->
                                                    <label class="btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6" data-kt-button="true">
                                                        <!--begin::Radio-->
                                                        <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                            <input class="form-check-input" type="radio" name="discount_option" value="2" />
                                                        </span>
                                                        <!--end::Radio-->
                                                        <!--begin::Info-->
                                                        <span class="ms-5">
                                                            <span class="fs-4 fw-bolder text-gray-800 d-block">Percentage %</span>
                                                        </span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col">
                                                    <!--begin::Option-->
                                                    <label class="btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6" data-kt-button="true">
                                                        <!--begin::Radio-->
                                                        <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                            <input class="form-check-input" type="radio" name="discount_option" value="3" />
                                                        </span>
                                                        <!--end::Radio-->
                                                        <!--begin::Info-->
                                                        <span class="ms-5">
                                                            <span class="fs-4 fw-bolder text-gray-800 d-block">Fixed Price</span>
                                                        </span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                       
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="d-none mb-10 fv-row" id="kt_ecommerce_add_product_discount_percentage">
                                            <!--begin::Label-->
                                            <label class="form-label">Set Discount Percentage1</label>
                                            <!--end::Label-->
                                            <!--begin::Slider-->
                                            <div class="d-flex flex-column text-center mb-5">
                                                <div class="d-flex align-items-start justify-content-center mb-7">
                                                    <span class="fw-bolder fs-3x" id="kt_ecommerce_add_product_discount_label">0</span>
                                                    <span class="fw-bolder fs-4 mt-1 ms-2">%</span>
                                                </div>
                                                <div id="kt_ecommerce_add_product_discount_slider" class="noUi-sm"></div>
                                            </div>
                                            <!--end::Slider-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Set a percentage discount to be applied on this product.</div>
                                            <!--end::Description-->
                                        </div>
                                        <div class="d-none mb-10 fv-row" id="kt_ecommerce_add_product_discount_fixed">
                                            <!--begin::Label-->
                                            <label class="form-label">Fixed Discounted Price</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="dicsounted_price" class="form-control mb-2" placeholder="Discounted price" />
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Set the discounted product price. The product will be reduced at the determined fixed price</div>
                                            <!--end::Description-->
                                        </div>
                                        <hr>
                                        <div class="fv-row mb-10">
                                            <label class="fs-6 fw-bold mb-2">Tax 
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Select a discount type that will be applied to this product"></i></label>
                                            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-1 row-cols-xl-3 g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
                                                <div class="col">
                                                    <label class="btn btn-outline btn-outline-dashed btn-outline-default active d-flex text-start p-6" data-kt-button="true">
                                                        <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                            <input class="form-check-input" type="radio" name="discount_tax_option" value="1" checked="checked" />
                                                        </span>
                                                        <span class="ms-5">
                                                            <span class="fs-4 fw-bolder text-gray-800 d-block">No Tax</span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col">
                                                    <label class="btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6" data-kt-button="true">
                                                        <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                            <input class="form-check-input" type="radio" name="discount_tax_option" value="2" />
                                                        </span>
                                                        <span class="ms-5">
                                                            <span class="fs-4 fw-bolder text-gray-800 d-block">Tax %</span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <div class="d-none d-flex flex-wrap gap-5" id="kt_ecommerce_add_product_tax_fixed">
                                            <!--begin::Input group-->
                                           
                                            <div class="fv-row w-100 flex-md-root">
                                                <!--begin::Label-->
                                                <label class="form-label">Tax Amount (%)</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control mb-2" value="" />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Set the product Tax about.</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                      
                                        <!--end::Input group-->
                                        <!--begin::Tax-->
                                        {{-- <div class="d-flex flex-wrap gap-5">
                                            <!--begin::Input group-->
                                            <div class="fv-row w-100 flex-md-root">
                                                <!--begin::Label-->
                                                <label class="required form-label">Tax Class</label>
                                                <!--end::Label-->
                                                <!--begin::Select2-->
                                                <select class="form-select mb-2" name="tax" data-control="select2" data-hide-search="true" data-placeholder="Select an option">
                                                    <option></option>
                                                    <option value="0">Tax Free</option>
                                                    <option value="1">Taxable Goods</option>
                                                    <option value="2">Downloadable Product</option>
                                                </select>
                                                <!--end::Select2-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Set the product tax class.</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row w-100 flex-md-root">
                                                <!--begin::Label-->
                                                <label class="form-label">VAT Amount (%)</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control mb-2" value="" />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Set the product VAT about.</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                        </div> --}}
                                        <!--end:Tax-->
                                    </div>
                                    <!--end::Card header-->
                                </div>
                                <!--end::Pricing-->
                            </div>
                        </div>
                        <!--end::Tab pane-->
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade" id="kt_ecommerce_add_product_advanced" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <!--begin::Inventory-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Inventory</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">SKU</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="sku" class="form-control mb-2" placeholder="SKU Number" value="" />
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Enter the product SKU.</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Barcode</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="sku" class="form-control mb-2" placeholder="Barcode Number" value="" />
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Enter the product barcode number.</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Quantity</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="d-flex gap-3">
                                                <input type="number" name="shelf" class="form-control mb-2" placeholder="On shelf" value="" />
                                                <input type="number" name="warehouse" class="form-control mb-2" placeholder="In warehouse" />
                                            </div>
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Enter the product quantity.</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Allow Backorders</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="form-check form-check-custom form-check-solid mb-2">
                                                <input class="form-check-input" type="checkbox" value="" />
                                                <label class="form-check-label">Yes</label>
                                            </div>
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Allow customers to purchase products that are out of stock.</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Card header-->
                                </div>
                                <!--end::Inventory-->
                                <!--begin::Variations-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Variations</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="" data-kt-ecommerce-catalog-add-product="auto-options">
                                            <!--begin::Label-->
                                            <label class="form-label">Add Product Variations</label>
                                            <!--end::Label-->
                                            <!--begin::Repeater-->
                                            <div id="kt_ecommerce_add_product_options">
                                                <!--begin::Form group-->
                                                <div class="form-group">
                                                    <div data-repeater-list="kt_ecommerce_add_product_options" class="d-flex flex-column gap-3">
                                                        <div data-repeater-item="" class="form-group d-flex flex-wrap gap-5">
                                                            <!--begin::Select2-->
                                                            <div class="w-100 w-md-200px">
                                                                <select class="form-select" name="product_option" data-placeholder="Select a variation" data-kt-ecommerce-catalog-add-product="product_option">
                                                                    <option></option>
                                                                    <option value="color">Color</option>
                                                                    <option value="size">Size</option>
                                                                    <option value="material">Material</option>
                                                                    <option value="style">Style</option>
                                                                </select>
                                                            </div>
                                                            <!--end::Select2-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control mw-100 w-200px" name="product_option_value" placeholder="Variation" />
                                                            <!--end::Input-->
                                                            <button type="button" data-repeater-delete="" class="btn btn-sm btn-icon btn-light-danger">
                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                        <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" />
                                                                        <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Form group-->
                                                <!--begin::Form group-->
                                                <div class="form-group mt-5">
                                                    <button type="button" data-repeater-create="" class="btn btn-sm btn-light-primary">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                                    <span class="svg-icon svg-icon-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                                            <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->Add another variation</button>
                                                </div>
                                                <!--end::Form group-->
                                            </div>
                                            <!--end::Repeater-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Card header-->
                                </div>
                                <!--end::Variations-->
                                <!--begin::Shipping-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Shipping</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="fv-row">
                                            <!--begin::Input-->
                                            <div class="form-check form-check-custom form-check-solid mb-2">
                                                <input class="form-check-input" type="checkbox" id="kt_ecommerce_add_product_shipping_checkbox" value="1" />
                                                <label class="form-check-label">This is a physical product</label>
                                            </div>
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Set if the product is a physical or digital item. Physical products may require shipping.</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Shipping form-->
                                        <div id="kt_ecommerce_add_product_shipping" class="d-none mt-10">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label">Weight</label>
                                                <!--end::Label-->
                                                <!--begin::Editor-->
                                                <input type="text" name="weight" class="form-control mb-2" placeholder="Product weight" value="" />
                                                <!--end::Editor-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Set a product weight in kilograms (kg).</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label">Dimension</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div class="d-flex flex-wrap flex-sm-nowrap gap-3">
                                                    <input type="number" name="width" class="form-control mb-2" placeholder="Width (w)" value="" />
                                                    <input type="number" name="height" class="form-control mb-2" placeholder="Height (h)" value="" />
                                                    <input type="number" name="length" class="form-control mb-2" placeholder="Lengtn (l)" value="" />
                                                </div>
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Enter the product dimensions in centimeters (cm).</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Shipping form-->
                                    </div>
                                    <!--end::Card header-->
                                </div>
                                <!--end::Shipping-->
                                <!--begin::Meta options-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Meta Options</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label">Meta Tag Title</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" class="form-control mb-2" name="meta_title" placeholder="Meta tag name" />
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Set a meta tag title. Recommended to be simple and precise keywords.</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label">Meta Tag Description</label>
                                            <!--end::Label-->
                                            <!--begin::Editor-->
                                            <div id="kt_ecommerce_add_product_meta_description" name="kt_ecommerce_add_product_meta_description" class="min-h-100px mb-2"></div>
                                            <!--end::Editor-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Set a meta tag description to the product for increased SEO ranking.</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div>
                                            <!--begin::Label-->
                                            <label class="form-label">Meta Tag Keywords</label>
                                            <!--end::Label-->
                                            <!--begin::Editor-->
                                            <input id="kt_ecommerce_add_product_meta_keywords" name="kt_ecommerce_add_product_meta_keywords" class="form-control mb-2" />
                                            <!--end::Editor-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Set a list of keywords that the product is related to. Separate the keywords by adding a comma 
                                            <code>,</code>between each keyword.</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Card header-->
                                </div>
                                <!--end::Meta options-->
                            </div>
                        </div>
                        <!--end::Tab pane-->
                    </div>
                    <!--end::Tab content-->
                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <a href="products.html" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait... 
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                </div>
                <!--end::Main column-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
    
@endsection
@section('add_on_script')
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&amp;l='+l:'';j.async=true;j.src= '../../../../../../www.googletagmanager.com/gtm5445.html?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-5FS8GGP');</script>
<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/save-product.js') }}"></script>
{{-- <script src="{{ asset('assets/js/custom/apps/calendar/calendar.js') }}"></script> --}}
<script src="{{ asset('assets/js/custom/apps/calendar/calendar.js') }}"></script>
{{-- <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script> --}}

<script>
    $(document).ready(function(){
        $(".turn-off-schedule").hide();
        // $(".from_to_date").hide();

    });
     $('.turn-on-schedule').on('click', event => {
        $(".turn-on-schedule").hide();
        $(".turn-off-schedule").show();
        $(".from_to_date").show();

    });

    $('.turn-off-schedule').on('click', event => {
        $(".turn-on-schedule").show();
        $(".turn-off-schedule").hide();
        $(".from_to_date").hide();
    });

       
</script>
    
@endsection