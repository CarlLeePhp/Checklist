

<div id="app">    
<div style="height: 50px;"></div>

<h2 class="text-center"><?php echo $title; ?></h2>

<hr />
<h4 class="text-center"><?php echo $message ?></h4>
<br />

    <form action="<?php echo base_Url(); ?>index.php/dealer/index" method="post">
        <input type="text" name="new" value="new" class="d-none"/>

        <div class="form-group row">
            <label for="dealer" class="offset-md-2 col-md-2 col-form-label text-right">Dealer:</label>
            <div class="col-md-4"> 
                <input type="text" name="dealer" class="form-control" placeholder="Dealer">
            </div>
            
        </div>    
        <div class="form-group row">
            <label for="sale" class="offset-md-2 col-md-2 col-form-label text-right">Sale:</label>
            <div class="col-md-4"> 
                <select name="sale" class="form-control">
	                <?php foreach ($sales as $sale): ?>
			            <option value="<?php echo $sale['SALE_ID']; ?>"><?php echo $sale['SALE_NAME']; ?></option>
		            <?php endforeach; ?>
	            </select>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </div>

    </form>
    <!-- form end -->
    <!-- Dealer Table -->
    <div class="row">
        <table class="table table-striped offset-md-2 col-md-8">
            <thead>
                <tr>
                    <th scop="col">Dealer</th>
                    <th scop="col">Sale</th>
                    <th scop="col">Buttons</th>
                </tr> 
            </thead>
            <tbody>
                <tr v-for="item in dealers">
                    <td>{{ item.name }}</td>
                    <td>{{ item.sale_name }}</td>
                    <td>
                        <a class="btn btn-success btn-sm" :href="item.edit" role="button">Edit</a>
                        <a class="btn btn-danger btn-sm" :href="item.remove" role="button">Remove</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Dealer Table End -->
</div> <!-- App -->


<!-- Vue -->
<!-- development version, includes helpful console warnings -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            dealers: [
                <?php foreach ($dealers as $dealer): ?>
                    {
                        id: "<?php echo $dealer['DEALER_ID'] ?>",
                        name: "<?php echo $dealer['DEALER_NAME'] ?>",
                        sale_name: "<?php echo $dealer['SALE_NAME'] ?>",
                        email: "<?php echo $dealer['SALE_EMAIL'] ?>",
                        edit: "<?php echo base_Url(); ?>index.php/dealer/edit_dealer/<?php echo $dealer['DEALER_ID'] ?>",
                        remove: "<?php echo base_Url(); ?>index.php/dealer/remove_dealer/<?php echo $dealer['DEALER_ID'] ?>"
                    },
                <?php endforeach; ?>
            ]
        },
        methods: {

        }
        
    })
</script>