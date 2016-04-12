@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div id="toolbar">
                <h4 class="paneltitle" style="display:inline;">Products</h4>
                <a href="/admin/add_product" style="display:inline; margin-left:10px;">
                    <button type="button" class="btn btn-sm btn-info">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add
                    </button>
                </a>
            </div>
            <table id="product_table" data-toolbar="#toolbar" data-toggle="table" data-show-columns="true" data-striped="true" class="table">
                <thead>
                    <tr>
                        <th class="text-center" data-field="id"><b>ID</b></th>
                        <th class="text-center" data-field="dt_create"><b>Date Added</b></th>
                        <th class="text-center" data-field="image"><b>Image</b></th>
                        <th class="text-center" data-field="title"><b>Title</b></th>
                        <th class="text-center" data-field="price"><b>Price</b></th>
                        <th class="text-center" data-field="action"><b>Action</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // go through the list of active products for the admin screen
                    foreach ($products as $product)
                    {
                        $img_url = asset('images/'.$product->id.'.'.$product->image_ext);
                        ?>    
                        <tr>
                            <td class="text-center">{{ $product->id }}</td>
                            <td class="text-center">{{ date('Y-m-d', strtotime($product->dt_created)) }}</td>
                            <td class="text-center"><img src="{{ $img_url }}" height="40"/></td>
                            <td class="text-center">{{ $product->title }}</td>
                            <td class="text-center">${{ $product->price }}</td>
                            <td class="text-center">
                                <a href="/admin/edit_product/{{ $product->id }}">
                                    <button type="button" class="btn btn-sm btn-primary">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                                    </button>
                                </a>
                                &nbsp;
                                <a href="/admin/delete_product/{{ $product->id }}">
                                    <button type="button" class="btn btn-sm btn-primary">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
