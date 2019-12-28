

<div id="app">    
<div style="height: 50px;"></div>

<h2 class="text-center"><?php echo $title; ?></h2>

<hr />
<br />

    <form action="<?php echo base_Url(); ?>index.php/checklist/index" method="post">
        <input type="text" name="remove" value="<?php echo $item['CLTP_ID'] ?>" class="d-none"/>
        <div class="form-group row">
            <label for="item" class="offset-md-2 col-md-2 col-form-label text-right">Check Item:</label>
            <div class="col-md-4"> 
                <input type="text" name="item" class="form-control" value="<?php echo $item['CLTP_DES'] ?>">
            </div>
            <button type="submit" class="btn btn-danger">Confirm</button>
            
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