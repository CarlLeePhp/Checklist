

<div id="app">    
<div style="height: 50px;"></div>

<h2 class="text-center"><?php echo $title; ?></h2>

<hr />
<h4 class="text-center"><?php echo $message ?></h4>
<br />

    <form action="<?php echo base_Url(); ?>index.php/boatmodel/index" method="post">
        <input type="text" name="new" value="new" class="d-none"/>
        <div class="form-group row">
            <label for="BoatModel" class="offset-md-2 col-md-2 col-form-label text-right">New Model:</label>
            <div class="col-md-4"> 
                <input type="text" name="BoatModel" id="" class="form-control" placeholder="New Boat Model">
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
            
        </div>
    </form>
    <!-- form end -->
    <!-- Boat Model Table -->
    <div class="row">
        <table class="table table-striped offset-md-2 col-md-8">
            <thead>
                <tr>
                    
                    <th scop="col" >Boat Model</th>
                    <th scop="col" >Buttons</th>
                </tr> 
            </thead>
            <tbody id="tableBody">
                <tr v-for="item in models" :key="item.id">
                    <td >{{ item.model }}</td>
                    <td >
                        <a class="btn btn-success btn-sm" :href="item.edit" role="button">Edit</a>
                        <a class="btn btn-danger btn-sm" :href="item.remove" role="button">Remove</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Boat Model Table End -->
</div> <!-- App -->


<!-- Vue -->
<!-- development version, includes helpful console warnings -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            models: [
                <?php foreach ($models as $model): ?>
                    {
                        id: "<?php echo $model['MODEL_ID'] ?>",
                        model: "<?php echo $model['MODEL'] ?>",
                        edit: "<?php echo base_Url(); ?>index.php/boatmodel/edit_model/<?php echo $model['MODEL_ID'] ?>",
                        remove: "<?php echo base_Url(); ?>index.php/boatmodel/remove_model/<?php echo $model['MODEL_ID'] ?>"
                    },
                <?php endforeach; ?>
            ]
        },
        methods: {

        }
        
    })
</script>