

<div id="app">    
<div style="height: 50px;"></div>

<h2 class="text-center"><?php echo $title; ?></h2>

<hr />
<h4 class="text-center"><?php echo $message ?></h4>
<br />

    <form action="<?php echo base_Url(); ?>index.php/boat/index" method="post">
        <input type="text" name="new" value="new" class="d-none"/>
        <div class="form-group row">
            <label for="dealer" class="offset-md-2 col-md-2 col-form-label text-right">Dealer:</label>
            <div class="col-md-4"> 
                <select name="dealer" class="form-control" @change="dealerHandler" v-model="dealer">
	                <?php foreach ($dealers as $dealer): ?>
			            <option value="<?php echo $dealer['DEALER_ID']; ?>"><?php echo $dealer['DEALER_NAME']; ?></option>
		            <?php endforeach; ?>
	            </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="model" class="offset-md-2 col-md-2 col-form-label text-right">Boat Model:</label>
            <div class="col-md-4"> 
                <select name="model" class="form-control">
	                <?php foreach ($models as $model): ?>
			            <option value="<?php echo $model['MODEL_ID']; ?>"><?php echo $model['MODEL']; ?></option>
		            <?php endforeach; ?>
	            </select>
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
                    <th scop="col">ID</th>
                    <th scop="col">Boat Model</th>
                    <th scop="col">Serial</th>
                    <th scop="col">Buttons</th>
                </tr> 
            </thead>
            <tbody>
                <tr v-for="item in boats">
                    <td>{{ item.id }}</td>
                    <td>{{ item.model }}</td>
                    <td>{{ item.serial }}</td>
                    <td>
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
            dealer: "0",
            boats: [
                {id: "0", model: "None", serial: "", edit: "", remove:""}
            ]
        },
        methods: {
            dealerHandler: function (){
                // insert a item for current boat model
                var formData = new FormData()
                formData.append('dealer_id', this.dealer)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/boat/get_boat/'
                this.$http.post(urllink, formData).then(response => {
                    // add a line in the table

                    var result = response.body
                    var results = result.split(",")
                    this.boats = []
                    for(i=0; i<results.length; i=i+3) {
                        this.boats.push({
                            id: results[i],
                            model: results[i+1],
                            serial: results[i+2],
                            edit: "<?php echo base_Url(); ?>" + 'index.php/boat/edit_boat/' + results[i],
                            remove: "<?php echo base_Url(); ?>" + 'index.php/boat/remove_boat/' + results[i]
                        })
                    }
                }, response => {
                    // error callback
                    this.messages = "Cannot find any boat."
                })
                
                          
            }
        }
        
    })
</script>