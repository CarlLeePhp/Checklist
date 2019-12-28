

<div id="app">    
<div style="height: 50px;"></div>

<h2 class="text-center"><?php echo $title; ?></h2>

<hr />
<br />

    <form action="<?php echo base_Url(); ?>index.php/boatmodel/index" method="post">
        <input type="text" name="update" value="<?php echo $boat_model['MODEL_ID'] ?>" class="d-none"/>
        <div class="form-group row">
            <label for="BoatModel" class="offset-md-2 col-md-2 col-form-label text-right">Boat Model:</label>
            <div class="col-md-4"> 
                <input type="text" name="BoatModel" class="form-control" value="<?php echo $boat_model['MODEL'] ?>">
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