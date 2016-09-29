<form method="post" data-product="{{ $product->id }}" action="{{ route('save_product', [ 'product' => $product->id ]) }}" class="form form-product"
      enctype="multipart/form-data">
    <div class="row add_product" id="sortable">
        <div class="inner_product border margin15">
            <div class="col l4 m6 s12">
                <div class="input-field">
                    <p>PHOTO</p>
                    <img class="materialboxed img-responsive" src="http://placehold.it/350x350">
                </div>
            </div>

            <div class="col l8 m6 s12">
                <div class="row">
                    <div class="col l6 s12">
                        <div class="input-field">
                            <span class="label">NAME</span>
                            <input type="text" required="" name="name" value="{{ ($product->name) ? : '' }}"
                                   placeholder="Product's name">
                        </div>
                    </div>

                    @if($lot->category_id)
                        @if(count($sub_categories = $lot->category->subCategories))
                            <div class="col l6 s12">
                                <div class="input-field">
                                    <span class="label">{{ strtoupper('Subcategory') }}</span>
                                    <select class="subcategories" name="sub_category">
                                        <option value="">Select subcategory</option>
                                        @foreach($sub_categories as $sub_category)
                                            <?php $selected = ($product->sub_category_id == $sub_category->id) ? 'selected' : ''; ?>
                                            <option value="{{ $sub_category->id }}"
                                                    {{ $selected }}>{{ $sub_category->present()->renderName() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><!-- Subcategories -->
                        @endif
                    @endif

                    <div class="col l6 s12">
                        <div class="input-field">
                            <span class="label">{{ strtoupper('old price') }}</span>
                            <input type="text" class="old_price" required name="old_price"
                                   value="{{ ($product->old_price) ? : '' }}"
                                   placeholder="0.00">
                            @if(count($currencies))
                                <span class="currency_type"
                                      style="position: absolute;top:31px;right: 15px;color: #ff6f00;">{{ ($lot->currency) ? $lot->currency->title : $currencies->first()->title }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col l6 s12 ">
                        <div class="input-field">
                            <span class="label">{{ strtoupper('new price') }}</span>
                            <input type="text" required="" class="new_price" name="price"
                                   value="{{ ($product->price) ? : '' }}"
                                   placeholder="0.00">
                            @if(count($currencies))
                                <span class="currency_type"
                                      style="position: absolute;top:31px;right: 15px;color: #ff6f00;">{{ ($lot->currency) ? $lot->currency->title : $currencies->first()->title }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col l6 s12">
                        <div class="input-field">
                            <span class="label">{{ strtoupper('SALE') }}</span>
                            <input type="text" class="create_sale" name="sale" placeholder="0%"
                                   value="{{ ($product->sale) ? : '' }}">
                            <span style="position: absolute;top:31px;right: 15px;color: #ff6f00;">%</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col l12 m12 s12">
                       <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="specification_suite_lot overflow">
                        <div class="specification_suite_item overflow" data-suite-spec="1">
                            <div class="col l6 m12 s12">
                                <div class="input-field spec_name">
                                    <span class="label">NAME</span>
                                    <input type="text" name="spec[1][key]" value="">
                                </div>
                            </div>
                            <div class="col l6 m12 s12">
                                <div class="input-field spec_value">
                                    <span class="label">DESCRIPTION</span>
                                    <input type="text" name="spec[1][value]" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col l1 m2 s2 offset-s10 offset-l11 offset-m10 center-align">
                        <a href="#add-spec" class="add_spec_btn add_suite"><i
                                    class="material-icons center">library_add</i></a>
                    </div>
                </div>

                <div class="row">
                    <div class="wrap_size_color_sold overflow">
                        <div class="size_color_sold_item overflow" data-suite-spec="1">
                            <div class="col l4 m12 s12">
                                <div class="input-field">
                                    <span class="label">Size</span>
                                    <input type="text" required="" name="size" value="" placeholder="Size">
                                </div>
                            </div>
                            <div class="col l4 m12 s12">
                                <div class="input-field">
                                    <span class="label">COLORS</span>
                                    <div class="file-field input-colorpicker">
                                        <div class="btn"></div>
                                        <div class="file-path-wrapper">
                                            <input type="text" name="color" class=""/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col l4 m12 s12">
                                <div class="input-field">
                                    <span class="label">Sold</span>
                                    <input type="text" required="" name="sold" value="" placeholder="0">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col l1 m2 s2 offset-s10 offset-l11 offset-m10 center-align">
                        <div class="input-field">
                            <a href="#add-spec" class="add_spec_btn add_size_color_sold"><i
                                        class="material-icons center">library_add</i></a>
                        </div>
                    </div>
                </div>

                <div class="row" style="height: 75px;margin-top: 20px">
                    <div class="col 2">
                        <div class="input-field">
                            <a href="#clone-product" class="clone-product btn amber darken-4"><i
                                        class="material-icons left">view_stream</i>Clone</a>
                        </div>
                    </div>

                    <div class="col 2">
                        <div class="row">
                            <div class="col l12 m12 s12">
                                <div class="input-field">
                                    <a href="#remove-product" onclick="deleteProductBlock(this); return false;"
                                       class="waves-effect waves-light btn red btn-remove-product"><i
                                                class="material-icons left">delete</i>Del</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col l6 s12 right-align-992">
                        <div class="input-field">
                            <button type="submit" onclick="saveProductBlock(this); return false;"
                                    class="waves-effect waves-light btn save-product"><i
                                        class="material-icons left">loop</i>Save
                            </button>
                            {{--<a href="#save-product" class="waves-effect waves-light btn save-product"><i class="material-icons left">loop</i>Save</a>--}}
                        </div>
                    </div>
                </div>
                <!--Add color size sold-->
            </div>
        </div>
    </div>

    {!! csrf_field() !!}
</form>