<style>
    tr.OPT{
        background-color: #c9c9c9;
    }
</style>

<div id="app">    
<div style="height: 50px;"></div>

<h2 class="text-center"><?php echo $title; ?></h2>

<hr />
<h4 class="text-center">{{ messages }}</h4>
<br />

    <form action="" v-on:submit.prevent="onSubmit">
        <input type="text" name="new" value="new" class="d-none"/>
        <div class="form-goup row">
            <label for="Model" class="offset-md-2 col-md-2 col-form-label text-right">Boat Model:</label>
            <div class="col-md-4"> 
                <select name="Model" id="Model" class="form-control" @change="model_handler" v-model="model">
                    <option value="0">Please Choose a Boat Model</option>
                    <option v-for="model in models" :key="model.id" :value="model.id">{{ model.model }}</option>
                </select>
                
            </div>
        </div>
        <br />
        <div class="form-group row">
            <label for="Item" class="offset-md-2 col-md-2 col-form-label text-right">New Item:</label>
            <div class="col-md-4"> 
                <input type="text" name="Item" id="" class="form-control" v-model="new_item" placeholder="New Item">
            </div>
            
            
        </div>
        <div class="form-goup row">
            <label for="type" class="offset-md-2 col-md-2 col-form-label text-right">Type:</label>
            <div class="col-md-4"> 
                <select name="type" class="form-control" v-model="item_type">
                    <option value="REQ">REQ</option>
                    <option value="OPT">OPT</option>  
                </select>
            </div>
            <button class="btn btn-primary" @click="add_item">Add</button>
        </div>
    </form>
    <!-- form end -->
    <br>
    <!-- Check List Table -->
    <div class="row">
        <table class="table offset-md-2 col-md-8">
            <thead>
                <tr>
                    
                    <th scop="col">Check List Item</th>
                    <th scop="col">Buttons</th>
                </tr> 
            </thead>
            <tbody id="tableBody">
                <tr v-for="item in items" :key="item.CL_ID" :class="item.TYPE">
                   
                    <td>{{ item.CLTP_DES }}</td>
                    <td>
                        <a class="btn btn-success" :href="'<?php echo base_Url(); ?>index.php/checklist/edit_item/'+item.CLTP_ID" role="button">Edit</a>
                        <a class="btn btn-danger" :href="'<?php echo base_Url(); ?>index.php/checklist/remove_item/'+item.CLTP_ID" role="button">Remove</a>
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>

    <!-- Check List Table End -->
</div> <!-- App -->


<!-- Vue -->
<!-- development version, includes helpful console warnings -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            messages: "<?php echo $message; ?>",
            model: "", // Boat Model ID
            new_item: "",
            item_type: "",
            models: [
                <?php foreach ($models as $model): ?>
                    {id: "<?php echo $model['MODEL_ID'] ?>", model: "<?php echo $model['MODEL'] ?>"},
                <?php endforeach; ?>
            ],
            items: [{CLTP_ID: "", CLTP_DES: "", BOAT_MODEL: "", TYPE: ""}]
        },
        methods: {
            model_handler : function(){
                var formData = new FormData()
                formData.append('model_id', this.model)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/checklist/get_item/'
                this.$http.post(urllink, formData).then(res => {
                    //refresh the table
                    var result = res.body
                    this.items = []
                    for (var i=0; i<result.length; i++){
                        this.items.push(result[i])
                    }
                    
                }, res => {
                    // error callback
                    this.messages = "POST FAIL"
                })
            },
            add_item : function(){
                // insert a item for current boat model
                var formData = new FormData()
                formData.append('model_id', this.model)
                formData.append('new_item', this.new_item)
                formData.append('type', this.item_type)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/checklist/add_item/'
                this.$http.post(urllink, formData).then(res => {
                    //refresh the table
                    var result = res.body
                    this.items = []
                    for (var i=0; i<result.length; i++){
                        this.items.push(result[i])
                    }
                }, res => {
                    // error callback
                    this.messages = "POST FAIL"
                })          
            },
            onSubmit: function(){

            }
        }
    })
</script>