

<div id="app">    
<div style="height: 50px;"></div>

<h2 class="text-center"><?php echo $title; ?></h2>

<hr />
<br />

    <form action="<?php echo base_Url(); ?>index.php/sale/index" method="post">
        <input type="text" name="update" value="<?php echo $sale['SALE_ID'] ?>" class="d-none"/>
        <div class="form-group row">
            <label for="sale_name" class="offset-md-2 col-md-2 col-form-label text-right">Name:</label>
            <div class="col-md-4"> 
                <input type="text" name="sale_name" class="form-control" value="<?php echo $sale['SALE_NAME'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="sale_email" class="offset-md-2 col-md-2 col-form-label text-right">Email:</label>
            <div class="col-md-4"> 
                <input type="text" name="sale_email" class="form-control" value="<?php echo $sale['SALE_EMAIL'] ?>">
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            
        </div>
    </form>
    <!-- form end -->
    
</div> <!-- App -->


<!-- Vue -->
<!-- development version, includes helpful console warnings -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            
        },
        methods: {

        }
        
    })
</script>