

<div id="app">    
<div style="height: 50px;"></div>

<h2 class="text-center"><?php echo $title; ?></h2>

<hr />
<br />

    <form action="<?php echo base_Url(); ?>index.php/cc/index" method="post">
        <input type="text" name="update" value="<?php echo $cc['CC_ID'] ?>" class="d-none"/>
        <div class="form-group row">
            <label for="cc_name" class="offset-md-2 col-md-2 col-form-label text-right">Name:</label>
            <div class="col-md-4"> 
                <input type="text" name="cc_name" class="form-control" value="<?php echo $cc['CC_NAME'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="cc_email" class="offset-md-2 col-md-2 col-form-label text-right">Email:</label>
            <div class="col-md-4"> 
                <input type="text" name="cc_email" class="form-control" value="<?php echo $cc['CC_EMAIL'] ?>">
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