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
        <div class="form-goup row">
            <label for="Dealer" class="offset-md-2 col-md-2 col-form-label text-right">Dealer:</label>
            <div class="col-md-4"> 
                <select name="Dealer" id="Dealer" class="form-control" v-model="dealer">
                    <option value="0">Please choose a Dealer</option>
                    <option v-for="dealer in dealers" :key="dealer.id" :value="dealer.id">{{ dealer.des }}</option>
                </select>
                
            </div>
        </div>

        <br />
        <div class="form-group row">
            <label for="model" class="offset-md-2 col-md-2 col-form-label text-right">Boat Model:</label>
            <div class="col-md-4"> 
                <select name="model" class="form-control" v-model="model">
                    <option value="0">Please choose a Boat Model</option>
	                <?php foreach ($models as $model): ?>
			            <option value="<?php echo $model['MODEL_ID']; ?>"><?php echo $model['MODEL']; ?></option>
		            <?php endforeach; ?>
	            </select>
            </div>
            
        </div>

        <div class="form-group row">
            <label for="serial" class="offset-md-2 col-md-2 col-form-label text-right">Serial:</label>
            <div class="col-md-4"> 
                <input type="text" name="serial" id="Serial" class="form-control" v-model="boat_serial" placeholder="Boat Serial Number">
            </div>
        </div>

        <div class="form-group row">
            <label for="model" class="offset-md-2 col-md-2 col-form-label text-right">Transporter:</label>
            <div class="col-md-4"> 
                <select name="transporter" class="form-control" v-model="transporter">
                    <option value="0">Please choose a Transporter</option>
                    <option v-for="transporter in transporters" :key="transporter.id" :value="transporter.id">{{ transporter.name }}</option>
                </select>
            </div>
            <button class="btn btn-primary" @click="new_boat" :disabled="isAddBoat">Add</button>
        </div>
    </form>
    <!-- form end -->

    <!-- Check List Table -->
    <div class="row">
        <table class="table offset-md-2 col-md-8">
            <thead>
                <tr>
                    <th scop="col">ID</th>
                    <th scop="col">Description</th>
                    <th scop="col">Checked</th>
                </tr> 
            </thead>
            <tbody>
                <tr v-for="item in items" :key="item.CL_ID" :class="item.TYPE">
                    <td>{{ item.CL_ID }}</td>
                    <td>{{ item.CL_DES }}</td>
                    <td><input type="checkbox" v-model="item.CHECKED"></td>
                    
                </tr>
                
            </tbody>
        </table>
    </div>
    <br />
    <!-- Check List Table End -->

    <div class="form-row">
        <div class="form-goup offset-md-2 col-md-8">
            <label for="miss">Missing Items</label>
            <textarea name="miss" id="miss" class="form-control" row="5" v-model="missed"> </textarea>
        </div>
    </div>
    <br />

    <div class="form-row">
        <div class="form-goup offset-md-2 col-md-8">
            <label for="additional">Additional Items</label>
            <textarea name="additional" class="form-control" row="5" v-model="additional"> </textarea>
        </div>
    </div>
    <br />
    <div class="d-flex justify-content-center">
            <!-- Choose Picture and preview, cannot cancel any picture -->
            <input type="file" name="userfile" id="userfile" @change="choose_picture" multiple="multiple">
    </div>
    <br />

    <h4 class="text-center">Pictures</h4>
    <hr />
    <div class="d-flex align-content-start flex-wrap">
        <div class="col-md-4 mb-2" v-for="item in picture_srcs" :key="item.id">
            <img :src="item.src" class="img-fluid" />
            <a href="#" class="text-danger" @click.stop.prevent="removePicture(item.name)">Delete</a>
            
        </div>
        
    </div>

    <div class="d-flex justify-content-center">
        <button class="btn btn-success" @click="upload_picture" :disabled="isSave">Save Checklist and Pictures</button>
        <button class="btn btn-warning ml-2" @click="create_email" :disabled="isSendEmail">Send Email</button>
    </div>
    <br />

    <!-- A Modal -->
    <div class="modal" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>{{ messages }}</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
    <!-- A Modal End -->

</div> <!-- App -->


<input type="hidden" name="img_val" id="img_val" value="" />
<br>
<br>
<!-- Vue -->
<!-- development version, includes helpful console warnings -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>

<script src="<?php echo base_Url(); ?>lib/html2canvas.js"></script>

<script>

    var app = new Vue({
        el: '#app',
        data: {
            dealer: "0",  // dealer_id
            boat: "0", // boat_id ??
            model: "0", // boat_model_id
            boat_serial: null, // boat serial number
            transporter: "0", // transporter id
            missed: "", // missing parts
            additional: "",
            messages: "<?php echo $message; ?>",
            dealers: [
                <?php foreach ($dealers as $dealer): ?>
                    {id: "<?php echo $dealer['DEALER_ID'] ?>", des: "<?php echo $dealer['DEALER_NAME'] ?>"},
                <?php endforeach; ?>
            ],
            
            boats: [
                {id: 0, model: "No model", serial: "No serial number"}
            ],
            serials: [
                <?php foreach ($boats as $boat): ?>
                <?php echo $boat['BOAT_SERIAL']; ?>,
                <?php endforeach; ?>
            ],
            transporters: [
                <?php foreach ($transporters as $transporter): ?>
                    {id: "<?php echo $transporter['TP_ID'] ?>", name: "<?php echo $transporter['TP_NAME'] ?>"},
                <?php endforeach; ?>
            ],
            items: [{CL_ID: 0, BOAT_ID: 0, CL_DES: "", CHECKED: 0, TYPE: ""}],
            userfiles: [], // Upload pictures, Array
            picture_srcs: [
                {id: 0, src: "", name: ""}
            ],
            // Conditions of buttons
            isAddBoat: false,
            isSave: true,
            isSendEmail: true
        },
        methods: {
            onSubmit: function (){

            },
            new_boat: function (){
                // Dealer ID, Model ID, Serial should be sent to insert a new boat
                // Then a folder named as serial, it should be checked before send these data
                if(this.dealer=="0") {
                    this.messages = "Please choose a Dealer.";
                    $('#myModal').modal('show')
                    return false
                }
                if(this.model=="0") {
                    this.messages = "Please choose a Boat Model.";
                    $('#myModal').modal('show')
                    return false
                }
                if(this.transporter=="0") {
                    this.messages = "Please choose a Transporter.";
                    $('#myModal').modal('show')
                    return false
                }
                if(isNaN(this.boat_serial) || this.boat_serial < 100000000 || this.boat_serial > 999999999 ) {
                    this.messages = "Serial should be a 9 digits number.";
                    $('#myModal').modal('show')
                    return false
                }
                for(var i=0; i<this.serials.length; i++){
                    if(this.serials[i] == this.boat_serial) {
                        this.messages = "The serial number is exist.";
                        $('#myModal').modal('show')
                        return false
                    }
                }

                // Post data
                var formData = new FormData()
                formData.append('dealer', this.dealer)
                formData.append('model', this.model)
                formData.append('serial', this.boat_serial)
                formData.append('transporter', this.transporter)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/pages/new_boat/'
                this.$http.post(urllink, formData).then(res => {
                    //refresh the table
                    var result = res.body
                    this.items = []
                    for(i=0;i<result.length;i++){
                        if(result[i].CHECKED == "0") {
                            result[i].CHECKED = false
                        } else {
                            result[i].CHECKED = true
                        }
                        this.items.push(result[i])  
                    }
                    // make the button disabled
                    this.isAddBoat = true
                    this.isSave = false
                }, res => {
                    // error callback
                    this.messages = "It was failed, please refresh this page and try again.";
                    $('#myModal').modal('show')
                })
            },
            choose_picture: function(){
                var userfile = document.getElementById("userfile")
                var len = userfile.files.length
                for(var i=0; i<len; i++){
                    this.userfiles.push(userfile.files[i])
                }
                this.picture_srcs =[]
                var tempList=[]
                for(var i=0; i<this.userfiles.length;i++){
                    let file_name = this.userfiles[i].name
                    try {
                        var reader = new FileReader();
                        reader.readAsDataURL(this.userfiles[i])
                        reader.onload = function(e){
                            var result = e.target.result
                            tempList.push({id: i, src: result, name: file_name})
                            // console.log(e.target.result)
                        }
                    } catch (e) {
                        console.log(e)
                    }
                    this.picture_srcs = tempList
                }
            },
            create_email: function(){
                
                var formData = new FormData()
                formData.append('dealer_id', this.dealer)
                formData.append('serial', this.boat_serial)
                formData.append('model_id', this.model)
                formData.append('email_type', "New")
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/pages/create_email/'
                this.$http.post(urllink, formData).then(res => {
                    var result = res.body
                    this.messages = result;
                    $('#myModal').modal('show')
                }, res => {
                    // error callback
                    var result = res.body
                    this.messages = result;
                    $('#myModal').modal('show')
                })
            },
            upload_picture: function(){
                // update checklist
                for(var i=0; i<this.items.length; i++){
                    var formData = new FormData()
                    formData.append('cl_id', this.items[i].CL_ID)
                    formData.append('checked', this.items[i].CHECKED)
                    var urllink = "<?php echo base_Url(); ?>" + 'index.php/pages/update_list/'
                    this.$http.post(urllink, formData).then(res => {
                        //refresh the table
                        var result = res.body
                        // this.messages = "Check List was updated successfully"
                        
                    }, res => {
                        // error callback
                        this.messages = "Check List was updated failed"
                    })
                }
                // Update missed description
                var formData = new FormData()
                formData.append('missed', this.missed)
                formData.append('additional', this.additional)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/pages/update_missed/'
                this.$http.post(urllink, formData).then(res => {
                    //refresh the table
                    var result = res.body
                    // this.messages = "Missed parts information was updated successfully"
                    
                }, res => {
                    // error callback
                    this.messages = "Missed parts information was updated failed"
                })

                // upload pictures
                for(var i=0; i<this.userfiles.length;i++){
                    var formData = new FormData()
                    formData.append('user_file', this.userfiles[i])
                    formData.append('dealer_id', this.dealer)
                    formData.append('serial', this.boat_serial)
                    var urllink = "<?php echo base_Url(); ?>" + 'index.php/pages/get_file/'
                    this.$http.post(urllink, formData).then(res => {
                        var result = res.body
                        // change the status of buttons
                        this.isSave = true
                        this.isSendEmail = false
                    
                    }, res => {
                        // error callback
                        this.messages = "Pictures were uploaded failed"
                    })
                }
                // show a message
                this.messages = "Successfully"
                
            },
            removePicture: function(fileName){
                for(var i=0; i<this.picture_srcs.length; i++){
                    if(this.picture_srcs[i].name == fileName){
                        this.picture_srcs.splice(i, 1)
                    }
                    
                }
                for (var i=0; i<this.userfiles.length; i++){
                    if(this.userfiles[i].name == fileName){
                        this.userfiles.splice(i, 1)
                    }
                }
            }
        }
    })
</script>

