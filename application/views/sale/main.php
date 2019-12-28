

<div id="app">    
<div style="height: 50px;"></div>

<h2 class="text-center"><?php echo $title; ?></h2>

<hr />
<h4 class="text-center"><?php echo $message ?></h4>
<br />

    <form action="<?php echo base_Url(); ?>index.php/sale/index" method="post">
        <input type="text" name="new" value="new" class="d-none"/>
        <div class="form-group row">
            <label for="sale_name" class="offset-md-2 col-md-2 col-form-label text-right">Name:</label>
            <div class="col-md-4"> 
                <input type="text" name="sale_name" class="form-control" placeholder="Full Name">
            </div>
        </div>
        <div class="form-group row">
            <label for="sale_email" class="offset-md-2 col-md-2 col-form-label text-right">Email:</label>
            <div class="col-md-4"> 
                <input type="text" name="sale_email" class="form-control" placeholder="Email Address">
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
                    <th scop="col">Name</th>
                    <th scop="col">Email</th>
                    <th scop="col">Buttons</th>
                </tr> 
            </thead>
            <tbody>
                <tr v-for="item in sales">
                    <td>{{ item.name }}</td>
                    <td>{{ item.email }}</td>
                    <td>
                        <a class="btn btn-success" :href="item.edit" role="button">Edit</a>
                        <a class="btn btn-danger" :href="item.remove" role="button">Remove</a>
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
            sales: [
                <?php foreach ($sales as $sale): ?>
                    {
                        id: "<?php echo $sale['SALE_ID'] ?>",
                        name: "<?php echo $sale['SALE_NAME'] ?>",
                        email: "<?php echo $sale['SALE_EMAIL'] ?>",
                        edit: "<?php echo base_Url(); ?>index.php/sale/edit_sale/<?php echo $sale['SALE_ID'] ?>",
                        remove: "<?php echo base_Url(); ?>index.php/sale/remove_sale/<?php echo $sale['SALE_ID'] ?>"
                    },
                <?php endforeach; ?>
            ]
        },
        methods: {

        }
        
    })
</script>